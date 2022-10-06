#ifdef ESP32
  #include <WiFi.h>
  #include <HTTPClient.h>
#else
  #include <ESP8266WiFi.h>
  #include <ESP8266HTTPClient.h>
  #include <WiFiClient.h>
#endif
#include <Arduino_JSON.h>

const char* ssid = " ";
const char* password = " ";

const char* JSON_get_URL = "https://webio.vo1d.cf/esp-inputs-action.php?action=inputs_state&board=2";
String SQL_update_URL = "https://webio.vo1d.cf/esp-inputs-action.php?action=inputs_update";

const long interval = 2000;
unsigned long previousMillis = 0;

String GPIO_and_type;

const int trigP = 2;  
const int echoP = 0; 

long duration;
int distance;

void setup() {
  pinMode(trigP, OUTPUT);  // Sets the trigPin as an Output
  pinMode(echoP, INPUT);   // Sets the echoPin as an Input
  Serial.begin(115200);
  
  WiFi.begin(ssid,password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) { 
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

  
}

void loop() {
  digitalWrite(trigP, LOW);   // Makes trigPin low
  delayMicroseconds(2);       // 2 micro second delay 
  digitalWrite(trigP, HIGH);  // tigPin high
  delayMicroseconds(10);      // trigPin high for 10 micro seconds
  digitalWrite(trigP, LOW);   // trigPin low
  duration = pulseIn(echoP, HIGH);   //Read echo pin, time in microseconds
  distance= duration*0.034/2;        //Calculating actual/real distance

  unsigned long currentMillis = millis();
  
  if(currentMillis - previousMillis >= interval) {
    if(WiFi.status()== WL_CONNECTED ){ 
      
     GPIO_and_type = httpGETRequest(JSON_get_URL);
      Serial.println(GPIO_and_type);
      JSONVar GPIO = JSON.parse(GPIO_and_type);

      if (JSON.typeof(GPIO) == "undefined") {
        Serial.println("Parsing input failed!");
        return;
      }
      
      
      Serial.print("JSON object input = ");
      Serial.println(GPIO);
    
      JSONVar GPIOkeys = GPIO.keys();


      int VALUE=0;

      for (int i = 0; i < GPIOkeys.length(); i++) {
        //JSONVar type = GPIO[GPIOkeys[i]];
        //pinMode(atoi(GPIOkeys[i]), INPUT);
        //if (type==1)
         // VALUE = digitalRead(atoi(GPIOkeys[i]));
        //else if (type==0)
          //VALUE = analogRead(atoi(GPIOkeys[i]));
        if (echoP==atoi(GPIOkeys[i]))
          VALUE = distance;

        String random_unneeded_string;

        String SQL_req = SQL_update_URL+"&board="+String(2)+"&gpio="+String(atoi(GPIOkeys[i]))+"&value="+String(VALUE)+"";
        random_unneeded_string = httpGETRequest(SQL_req.c_str());
         Serial.print("GPIO: ");
          Serial.print(atoi(GPIOkeys[i]));
          Serial.print(" gave a value= ");
          Serial.println(VALUE);
      }

      previousMillis = currentMillis;
    }
    else {
      Serial.println("WiFi Disconnected");
    }
  }
}

String httpGETRequest(const char* serverName) {
  #ifdef ESP32
  HTTPClient http; 
  http.begin(serverName);
  #else
  WiFiClient client;
  HTTPClient http;
  // Your IP address with path or Domain name with URL path 
  http.begin(client, serverName);
  #endif 
  // Send HTTP POST request
  int httpResponseCode = http.GET();
  
  String payload = "{}"; 
  
  if (httpResponseCode>0) {
    Serial.print("HTTP Response code: ");
    Serial.println(httpResponseCode);
    payload = http.getString();
  }
  else {
    Serial.print("Error code: ");
    Serial.println(httpResponseCode);
  }
  // Free resources
  http.end();

  return payload;
}