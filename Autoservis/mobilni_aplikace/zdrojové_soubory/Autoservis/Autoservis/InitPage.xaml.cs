using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace Autoservis
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class InitPage : ContentPage
    {
        public InitPage()
        {
            InitializeComponent();
            
        }
        protected override void OnAppearing()
        {
            CheckToken();

            base.OnAppearing();
        }
        public void CheckToken()
        {
            var app = Application.Current as App;
            if (app.Token != "")
            {
                DateTime dateNow = DateTime.Now;
                var dateEx = DateTime.Parse(app.ExpireDate);
                if (dateNow > dateEx)
                {
                    app.Token = "";
                    app.ExpireDate = "";
                    app.MainPage = new Login();
                }
                else
                {
                    app.MainPage = new MenuPage();

                }

            }
            else
            {
                app.MainPage = new Login();
            }


        }

    }
}