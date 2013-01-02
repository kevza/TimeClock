using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;


namespace TimeClock
{	/// <summary>
	/// Timeclock main form
	/// </summary>
    public partial class Form1 : Form
    {
		
		private Settings mySettings;
		private HttpAccess httpA;
		/// <summary>
		/// Initializes a new instance of the <see cref="TimeClock.Form1"/> class.
		/// </summary>
        public Form1()
        {
            InitializeComponent();
			//Initialize helper classes
			mySettings = new Settings();
			httpA = new HttpAccess(mySettings);
        	this.addEventHandlers();
			this.fillCboUsers();
			//Need to set credentials to access server
			
		}
		/// <summary>
		/// Adds the event handlers.
		/// </summary>
		private void addEventHandlers(){
			this.btnIn.Click += new EventHandler(this.btnLogin);
			this.btnOut.Click += new EventHandler(this.btnLogout);
			this.cboUser.SelectedIndexChanged += new EventHandler(this.cboUserChanged);
			this.txtPw.TextChanged += new EventHandler(this.txtPwChanged);
		}
		
		/// <summary>
		/// Fills the cboUsers combo box.
		/// </summary>
		private void fillCboUsers(){
			string users = httpA.getHttpText("http://"+mySettings.serverUrl + "/users.php");
			int c = 0;
			for (int k = 0; k < users.Length; k++){
				if (users[k] == '<')
					c += 1;
				if (users[k] == '>')
					c -= 1;
				if (c < 0){
					System.Console.WriteLine("Error String Parsed Incorrectly");	
				}
			}
			if (c > 0)
					System.Console.WriteLine("Error String Parsed Incorrectly");
			
			System.Console.WriteLine(users);
			int i = -6;string user;
			int j = -7;
			while (true){
				i = users.IndexOf("<user>",i+6);
				j = users.IndexOf("</user>",j+7);
				if (i == -1 || j == -1)
					break;
				user = users.Substring(i+6,j - i - 6);
				this.cboUser.Items.Add(user);
			}
		}
		
		/// <summary>
		/// Processes btnLogin Event
		/// </summary>
		/// <param name='sender'>
		/// Sender.
		/// </param>
		/// <param name='e'>
		/// E.
		/// </param>
		private void btnLogin(object sender,EventArgs e){
			string postData="";
			postData += "User="+this.cboUser.Text+"&";
			postData += "Password="+this.txtPw.Text+"&";
			postData += "Date="+DateTime.Now.ToString("yyyy-MM-dd")+"&";
			postData += "Time="+DateTime.Now.ToString("HH:mm:ss")+"&";
			postData += "InOut="+"In";
			string resp = httpA.sendHttpPost("http://"+mySettings.serverUrl+"/update.php",postData);
			System.Console.WriteLine(resp);
            //Pocess the response from server      
			if (resp.Equals("LoggedIn")){
				//Every thing is good and the sun is shining
				MessageBox.Show (this.cboUser.Text + " signed in at : " + DateTime.Now.ToString("HH:mm:ss"));
			}
			
			if (resp.Equals("ErrorLoggedIn")){
				MessageBox.Show ("You are already signed in.");
			}
			
			if (resp.Equals("ErrorUser")){
				MessageBox.Show ("Incorrect User or Password");			
			}
			
			
		}
			
		/// <summary>
		/// Processes btnLogout Event
		/// </summary>
		/// <param name='sender'>
		/// Sender.
		/// </param>
		/// <param name='e'>
		/// E.
		/// </param>
		private void btnLogout(object sender,EventArgs e){
			string postData="";
			postData += "User="+this.cboUser.Text+"&";
			postData += "Password="+this.txtPw.Text+"&";
			postData += "Date="+DateTime.Now.ToString("yyyy-MM-dd")+"&";
			postData += "Time="+DateTime.Now.ToString("HH:mm:ss")+"&";
			postData += "InOut="+"Out";
			string resp = httpA.sendHttpPost("http://"+mySettings.serverUrl+"/update.php",postData);
      		//Process the response from the server     
			if (resp.Equals("LoggedOut")){
				//Every thing is good and the sun is shining	
				MessageBox.Show (this.cboUser.Text + " signed out at : " + DateTime.Now.ToString("HH:mm:ss"));
			}
			
			if (resp.Equals("ErrorLoggedOut")){
				MessageBox.Show ("You are already signed out.");
			}
			
			if (resp.Equals("ErrorUser")){
				MessageBox.Show ("Incorrect User or Password");			
			}
			
			
			
			
		}
		/// <summary>
		/// User Selected Changed.
		/// </summary>
		/// <param name='sender'>
		/// Sender.
		/// </param>
		/// <param name='e'>
		/// E.
		/// </param>
		private void cboUserChanged(object sender,EventArgs e){

			
		}	
		
		/// <summary>
		/// Password Text Changed
		/// </summary>
		/// <param name='sender'>
		/// Sender.
		/// </param>
		/// <param name='e'>
		/// E.
		/// </param>
		private void txtPwChanged(object sender,EventArgs e){

			
		}
		
		
    }
}
