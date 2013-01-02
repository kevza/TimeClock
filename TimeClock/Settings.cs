using System;
using System.IO;
namespace TimeClock
{
	/// <summary>
	/// Settings. Loads basic settings from the settings.inf file
	/// </summary>
	public class Settings
	{
		/// <summary>
		/// The server pw. Holds the password for the callin server
		/// </summary>
		public string serverPw;
		/// <summary>
		/// The server user. Hold the user name for the callin server
		/// </summary>
		public string serverUser;
		/// <summary>
		/// The server URL. Holds the server url
		/// </summary>
		public string serverUrl;
		private const string URL_ID = "Server.url=";
		private const string USER_ID = "Server.user=";
		private const string PW_ID = "Server.pw=";
		
		/// <summary>
		/// Initializes a new instance of the <see cref="TimeClock.Settings"/> class.
		/// </summary>
		public Settings (){
			
			//Get the settings path where we have permissions to save
            string path = Environment.GetFolderPath(Environment.SpecialFolder.LocalApplicationData);
 			System.Console.WriteLine(path);

			if (!File.Exists(path + "/tc_settings.inf")){
				serverPw = "PASSWORD";
				serverUser = "USER";
				serverUrl = "SERVERURL";
				try{
                    StreamWriter sw = new StreamWriter(path + "/tc_settings.inf");
					sw.WriteLine(URL_ID + serverUrl);
					sw.WriteLine(USER_ID + serverUser);
					sw.WriteLine(PW_ID + serverPw);
					sw.Close();
				}catch (Exception e){
					System.Console.WriteLine("Failed to create settings file");
					System.Console.WriteLine(e.Message);		
				}
			}else{	
				try{
	            	// Create an instance of StreamReader to read from a file.
	            	// The using statement also closes the StreamReader.
                    using (StreamReader sr = new StreamReader(path + "/tc_settings.inf"))
	            	{
	                	String line;
	                	// Read and display lines from the file until the end of
	                	// the file is reached.
	                	while ((line = sr.ReadLine()) != null)
	                	{
	                    	if (line.Contains(URL_ID)){
								this.serverUrl = line.Substring(URL_ID.Length); 
								continue;
							}
							if (line.Contains(USER_ID)){
								this.serverUser = line.Substring(USER_ID.Length);
								
								continue;
							}
							if (line.Contains(PW_ID)){
								this.serverPw = line.Substring(PW_ID.Length);
								
								continue;
							}
	                	}
	            	}
	        	}
	        	catch (Exception e)
	        	{
	            	// Let the user know what went wrong.
	            	Console.WriteLine("The file could not be read:");
	            	Console.WriteLine(e.Message);
	        	}
			}
		}
	}
}

