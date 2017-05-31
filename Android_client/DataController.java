package com.example.lluismontabes.gameofboatsandcards.Gamecloud;

import android.os.AsyncTask;
import android.support.annotation.Nullable;

import com.example.lluismontabes.gameofboatsandcards.Interface.GameActivity;
import com.google.gson.Gson;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 * Created by lmontaga7.alumnes on 31/05/17.
 */

public class DataController {

    /*
     * Host parameters
     */
    private final String hostUrl;

    /*
     * CONNECTION PARAMETERS
     */
    private int frequency;
    private boolean connectionActive;
    private boolean unlimitedCollection;

    /*
     * SYNCHRONIZATION
     */
    private boolean shouldUpdate = false;

    /*
     * Stats
     */
    private int updates = 0;

    /*
     * MATCH PARAMETERS
     */
    // Match id
    private int matchId;

    // Player assignation
    private int assignedPlayer;
    private int oppositePlayer;

    // Player readyness
    private boolean localPlayerReady = false;
    private boolean remotePlayerReady = false;

    /*
     * PARAMETERS
     */
    ArrayList<Parameter> parameters;

    /*
     * SERVER SCRIPTS
     */
    Script connectionScript = new Script(Script.Type.CONNECTION, "connection.php");
    Script checkConnectionScript = new Script(Script.Type.CHECK_CONNECTION, "check_connection.php");
    Script sendLocalEventScript = new Script(Script.Type.SEND_LOCAL_EVENT, "send_local_event.php");
    Script retrieveRemoteEventScript = new Script(Script.Type.RETRIEVE_REMOTE_EVENT, "retrieve_remote_event.php");
    Script sendLocalParamScript = new Script(Script.Type.SEND_PARAM, "write_param.php"); // TODO
    Script retrieveRemoteParamScript = new Script(Script.Type.RETRIEVE_PARAM, "read_param.php");

    /**
     * Default constructor for DataController.
     * @param assignedPlayer        Assigned player number in the server.
     * @param hostUrl               Full url of the server host (http://www.example.com/).
     * @param f                     Frequency (in frames) at which to attempt to access the server.
     * @param connectionActive      Whether to activate the connection right away or not.
     * @param unlimitedConnection   Whether or not to attempt to connect to the host independently of FPS. WARNING: Setting this to true will be very host-consuming.
     */
    public DataController(int matchId, int assignedPlayer, String hostUrl, boolean connectionActive, int f, boolean unlimitedConnection){
        this.matchId = matchId;
        this.assignedPlayer = assignedPlayer;
        this.hostUrl = hostUrl;
        this.connectionActive = connectionActive;
        this.frequency = f;
        this.unlimitedCollection = unlimitedConnection;
    }

    // SETTERS

    /**
     * Set frequency (in frames) at which to attempt to access the server..
     * @param f Frequency (in frames)
     */
    public void setFrequency(int f){
        this.frequency = f;
    }

    /**
     * Set whether the DataController will connect to the host or not.
     * @param connectionActive  Boolean connectionActive
     */
    public void setConnectionActive(boolean connectionActive){
        this.connectionActive = connectionActive;
    }


    // GETTERS

    /**
     * Returns the current frequency (in frames)
     * @return Frequency (in frames)
     */
    public int getFrequency(){
        return this.frequency;
    }

    /**
     * Returns whether or not connection is active.
     * @return Boolean connectionActive
     */
    public boolean isConnectionActive(){
        return this.connectionActive;
    }

    // COMMANDS

    /**
     * Update DataController to send and retrieve the latest data.
     */
    public void update(){
        shouldUpdate = true;
    }

    // DATA GATHERING

    /**
     * Get JSON response as String from URL.
     *
     * @param url     URL to retrieve JSON from.
     * @param timeout Time available to establish connection.
     * @return JSON response as String.
     */
    @Nullable
    private String getJSON(String url, int timeout) {
        HttpURLConnection c = null;
        try {
            URL u = new URL(url);
            c = (HttpURLConnection) u.openConnection();
            c.setRequestMethod("GET");
            c.setRequestProperty("Content-length", "0");
            c.setUseCaches(false);
            c.setAllowUserInteraction(false);
            c.setConnectTimeout(timeout);
            c.setReadTimeout(timeout);
            c.connect();
            int status = c.getResponseCode();

            switch (status) {
                case 200:
                case 201:
                    BufferedReader br = new BufferedReader(new InputStreamReader(c.getInputStream()));
                    StringBuilder sb = new StringBuilder();
                    String line;
                    while ((line = br.readLine()) != null) {
                        sb.append(line);
                        sb.append("\n");
                    }
                    br.close();
                    return sb.toString();
            }

        } catch (MalformedURLException ex) {
            Logger.getLogger(getClass().getName()).log(Level.SEVERE, null, ex);
        } catch (IOException ex) {
            Logger.getLogger(getClass().getName()).log(Level.SEVERE, null, ex);
        } finally {
            if (c != null) {
                try {
                    c.disconnect();
                } catch (Exception ex) {
                    Logger.getLogger(getClass().getName()).log(Level.SEVERE, null, ex);
                }
            }
        }
        return null;
    }

    private class EventIndexPair{

        public EventIndexPair(Event e, int i){
            this.event = e;
            this.eventIndex = i;
        }

        int eventIndex;
        Event event;
    }

    private class PointAnglePair{
        int x;
        int y;
        float angle;
    }

    private class ScorePair{
        int score1;
        int score2;
    }

    public class RemoteDataTask extends AsyncTask<String, String, Void> {

        // OVERRIDEN METHODS

        protected void onPreExecute() {
            super.onPreExecute();
        }

        protected Void doInBackground(String... params) {

            // Notify the server that the local player is ready.
            notifyLocalPlayerReady();

            while (connectionActive) {

                if (!remotePlayerReady){

                    // Ask the server if the remote player is ready yet.
                    checkRemotePlayerReady();

                }else {

                    if (unlimitedCollection || shouldUpdate) {

                        updates++;

                        sendLocalParamData();

                        /*
                        // Send local scoring data
                        sendLocalScoreData();

                        // Retrieve both players' scoring data
                        retrieveScoreData();

                        // Send position & angle data
                        sendLocalPositionData();

                        // Retrieve position & angle data
                        retrieveRemotePositionData();

                        // Send event flag data
                        sendLocalEventData();

                        // Retrieve event flag data
                        retrieveRemoteEventData();
                        */

                        shouldUpdate = false;

                    }

                }

            }

            return null;

        }

        // PLAYER READYNESS

        private void notifyLocalPlayerReady(){

            // Set the playerX_ready column to 1 on the server database.
            getJSON(hostUrl + "send_local_ready.php?matchId=" + matchId
                    + "&player=" + assignedPlayer
                    + "&ready=" + 1, 2000);

        }

        private void checkRemotePlayerReady(){

            // This returns a string containing either 1 or 0, representing a boolean value.
            String data = getJSON(hostUrl + "retrieve_remote_ready.php?matchId=" + matchId
                    + "&player=" + oppositePlayer, 2000);

            System.out.println("Ready: " + data);

            // Get first character, as, for some reason, it returns one extra character.
            int ready = Integer.parseInt(data.substring(0, 1));

            if (ready == 1){
                remotePlayerReady = true;
            }

        }

        // DATA GATHERING

        private void sendLocalParamData(){

            for (Parameter p : parameters){

                //getScriptResponse(Script.SEND_LOCAL_PARAM);

            }

        }

        /*private void sendLocalScoreData() {

            getJSON(hostUrl + "send_local_score.php?matchId=" + matchId
                    + "&player=" + assignedPlayer
                    + "&score=" + localScore, 2000);

        }

        private void retrieveScoreData() {

            //This returns a JSON object with a {"score1": int, "score2": int} pattern.
            String data = getJSON(hostUrl + "retrieve_scores.php?matchId=" + matchId, 2000);

            // Parse the JSON information into a ScorePair object.
            GameActivity.ScorePair p = new Gson().fromJson(data, GameActivity.ScorePair.class);

            // Set score1 and score2 variables retrieved from JSON to the localScore and
            // remoteScore global variables.
            if (p != null){
                if(assignedPlayer == 1 || assignedPlayer == -1){
                    remoteScore = p.score2;
                }else{
                    remoteScore = p.score1;
                }
            }
        }

        private void sendLocalEventData() {

            if(!localUnsentEvents.isEmpty()){

                GameActivity.EventIndexPair eventIndexPair = localUnsentEvents.get(0);

                GameActivity.Event event = eventIndexPair.event;
                int eventIndex = eventIndexPair.eventIndex;
                int eventNumber = event.ordinal();

                System.out.println("EVENT: " + event);
                System.out.println("INDEX: " + eventIndex);

                getJSON(hostUrl + "send_local_event.php?matchId=" + matchId
                                + "&player=" + assignedPlayer
                                + "&event=" + eventNumber
                                + "&eventIndex=" + eventIndex,
                        2000);

                lastSentLocalEventIndex = eventIndex;
                localUnsentEvents.remove(0);

            }

        }

        private void retrieveRemoteEventData(){

            //This returns a JSON object with a {"eventIndex": int, "event": int} pattern.
            String data = getJSON(hostUrl + "retrieve_remote_event.php?matchId=" + matchId
                    + "&player=" + oppositePlayer, 2000);

            // Parse the JSON information into an EventIndexPair object.
            GameActivity.EventIndexPair p = new Gson().fromJson(data, GameActivity.EventIndexPair.class);

            // Set event and eventIndex variables retrieved from JSON to the remoteActiveEvent and
            // remoteEventIndex global variables.
            // These variables will be used to process events locally on the next frame.
            if (p != null){
                if (p.eventIndex > remoteEventIndex){

                    remoteActiveEvent = p.event;
                    remoteEventIndex = p.eventIndex;

                }
            }

        }

        private void sendLocalPositionData() {

            getJSON(hostUrl + "send_local_position.php?matchId=" + matchId
                            + "&player=" + assignedPlayer
                            + "&x=" + localPosition.x
                            + "&y=" + localPosition.y
                            + "&angle=" + localAngle,
                    2000);

            System.out.println(localAngle);

        }

        private void retrieveRemotePositionData() {

            //This returns a JSON object with a {"x": int,"y": int} pattern.
            String data = getJSON(hostUrl + "retrieve_remote_position.php?matchId=" + matchId
                    + "&player=" + oppositePlayer, 2000);

            System.out.println(currentFrame + ": " + data);

            // Parse the JSON information into a Point object.
            GameActivity.PointAnglePair p = new Gson().fromJson(data, GameActivity.PointAnglePair.class);

            // Set X and Y coordinates retrieved from JSON to the remotePosition.x and remotePosition.y global
            // variables. These variables will be used to position remotePlayer on the next frame.
            if (p != null) {

                remotePosition.set(p.x, p.y);
                remoteAngle = p.angle;

                lastCheckSuccessful = true;
                latency = (currentFrame - lastFrameChecked) / 30;

            } else {
                lastCheckSuccessful = false;
            }

        }*/

    }

}
