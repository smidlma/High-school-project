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
    public partial class Login : ContentPage
    {
        public Login()
        {
            //if (Device.RuntimePlatform == Device.iOS)
            //{
            //    this.Padding = new Thickness(0, 20, 0, 0);
            //}
            InitializeComponent();
            //var app = Application.Current as App;
            //DisplayAlert("Test", app.Token + "/" + app.ExpireDate, "OK");
        }



        private async void Button_ClickedAsync(object sender, EventArgs e)
        {
            if (email.Text != null && password.Text != null)
            {
                activityIndicator.IsVisible = true;
                activityIndicator.IsRunning = true;
                try
                {
                    var call = new RestApi();
                    if (await call.Login(email.Text, password.Text))
                    {
                        Application.Current.MainPage = new MenuPage();
                    }
                    else
                    {
                        await DisplayAlert("Error", "Nesprávné jméno nebo heslo", "OK");
                    }
                }
                catch
                {
                   await DisplayAlert("Error", "Připojení selhalo", "OK");
                }
                activityIndicator.IsRunning = false;
                activityIndicator.IsVisible = false;

            }
            else
            {
                email.Focus();
            }

        }
    }
}