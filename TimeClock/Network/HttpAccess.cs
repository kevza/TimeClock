using System;
using System.Collections.Generic;
using System.Text;
using System.Net;
using System.IO;


namespace TimeClock
{
   	/// <summary>
   	/// A class for getting files and data by http. Also implements a post method for sending data to a website.
   	/// </summary>
    class HttpAccess
    {
		private NetworkCredential cred;
		/// <summary>
		/// Initializes a new instance of the <see cref="TimeClock.HttpAccess"/> class.
		/// </summary>
		public HttpAccess(){
			cred = new NetworkCredential();	
		}
		
		/// <summary>
		/// Initializes a new instance of the <see cref="TimeClock.HttpAccess"/> class.
		/// </summary>
		/// <param name='webSettings'>
		/// Web settings.
		/// </param>
		public HttpAccess(Settings webSettings){
			cred = new NetworkCredential(webSettings.serverUser,webSettings.serverPw);
			System.Console.WriteLine(webSettings.serverPw + "," + webSettings.serverUser);
		}
		
       	/// <summary>
       	/// Gets the http text returned by a website.
       	/// </summary>
       	/// <returns>
       	/// The website source http
       	/// </returns>
       	/// <param name='url'>
       	/// The websites url
       	/// </param>
        public String getHttpText(String url)
        {
            String temp;
            HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
			req.Credentials = cred;
            HttpWebResponse resp = (HttpWebResponse)req.GetResponse();
            StringBuilder sb = new StringBuilder();

                byte[] buffer = new byte[8192];

                Stream resStream = resp.GetResponseStream();
                int count = 0;
                do
                {
                    count = resStream.Read(buffer, 0, buffer.Length);
                    if (count != 0)
                    {
                        temp = Encoding.ASCII.GetString(buffer, 0, count);
                        sb.Append(temp);
                    }
                } while (count > 0);

            System.Console.WriteLine("File successfully retrieved from :" + url);
            return sb.ToString();
        }
        
		/// <summary>
		/// Sends a post request to a website.
		/// </summary>
		/// <returns>
		/// The status of the post success or failure  
		/// </returns>
		/// <param name='url'>
		/// The websites url.
		/// </param>
		/// <param name='data'>
		/// Data to send to the website. In standard post form 
		/// </param>
        public String sendHttpPost(String url, String data)
        {
            byte[] buffer = Encoding.ASCII.GetBytes(data);
            //Create Post
            HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
			req.Credentials = cred;
			req.PreAuthenticate = true;
            req.Method = "POST";
            req.ContentType = "application/x-www-form-urlencoded";
            req.ContentLength = buffer.Length;
            //Send Post Data
            Stream PostData = req.GetRequestStream();
            PostData.Write(buffer, 0, buffer.Length);
            PostData.Close();
            //Get Response from Server <- Not sure if I need to do this?
            HttpWebResponse resp = (HttpWebResponse)req.GetResponse();
            
			//Log the server response
            Console.WriteLine(resp.StatusCode);
            Console.WriteLine(resp.Server);
			//get the response stream
			byte []bf = new byte[8192];
			StringBuilder sb = new StringBuilder();
            Stream resStream = resp.GetResponseStream();
            String temp;
			int count = 0;
            do
           {
                    count = resStream.Read(bf, 0, bf.Length);
                    if (count != 0)
                    {
                        temp = Encoding.ASCII.GetString(bf, 0, count);
                        sb.Append(temp);
                    }
                } while (count > 0);
			
            if (resp.StatusCode == HttpStatusCode.OK)
                return sb.ToString();
    		return "";
        }
        /// <summary>
        ///	Downloads a file from a website
        /// </summary>
        /// <returns>
        /// A boolean Success or failure.
        /// </returns>
        /// <param name='url'>
        /// The url to pull the file from.
        /// </param>
        /// <param name='saveLocation'>
        /// The location and name to save the file to.
        /// </param>
        public bool getFileHttp(String url, String saveLocation)
        {
            WebClient client = new WebClient();
			client.Credentials = cred;
            try
            {
                client.DownloadFile(url, saveLocation);
	
            }
            catch
            {
                System.Console.WriteLine("Failed to fetch file from URL=" + url); 
                return false;
            }
            System.Console.WriteLine("Fetched file from URL=" +url); 
            return true;
        }
		/// <summary>
		/// Sends a file to the given url by http post.
		/// </summary>
		/// <returns>
		/// Success or failure.
		/// </returns>
		/// <param name='url'>
		/// The website URL.
		/// </param>
		/// <param name='fileName'>
		/// The file name.
		/// </param>
		public bool sendFilePost(String url,String fileName){
			try{
				WebClient client = new WebClient();
				//May need to rewrite this class with credentials
				client.Credentials = cred;
				byte [] response = client.UploadFile(url,fileName);
				System.Console.WriteLine(Encoding.UTF8.GetString(response));
			}catch{
                System.Console.WriteLine("File failed to upload to URL="+url);
				return false;
				
			}
            System.Console.WriteLine("File="+fileName+" Uploaded to URL="+url);
			return true;
		}

    }
}
