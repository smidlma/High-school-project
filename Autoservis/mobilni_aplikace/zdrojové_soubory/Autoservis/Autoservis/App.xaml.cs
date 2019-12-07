using System;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

[assembly: XamlCompilation(XamlCompilationOptions.Compile)]
namespace Autoservis
{
    public partial class App : Application
    {


        public App()
        {
            InitializeComponent();
            //MainPage = new Test();
        }

        protected override void OnStart()
        {
            // Handle when your app starts
            //Current.Properties.Clear();
            CheckToken();

        }

        protected override void OnSleep()
        {
            // Handle when your app sleeps
        }

        protected override void OnResume()
        {
            // Handle when your app resumes
        }
        public void CheckToken()
        {
            if (Token != "")
            {
                DateTime dateNow = DateTime.Now;
                var dateEx = DateTime.Parse(ExpireDate);
                if (dateNow > dateEx)
                {
                    Current.Properties.Clear();
                    MainPage = new Login();
                }
                else
                {
                    MainPage = new MenuPage();

                }

            }
            else
            {
                MainPage = new Login();
            }
            
        }
        public string Token
        {
            get
            {
                if (Properties.ContainsKey("token"))
                {
                    return Properties["token"].ToString();
                }

                return "";
            }
            set
            {
                Properties["token"] = value;
            }

        }
        public string ExpireDate
        {
            get
            {
                if (Properties.ContainsKey("date"))
                {
                    return Properties["date"].ToString();
                }

                return "";
            }
            set
            {
                Properties["date"] = value;
            }
        }
    }
}
