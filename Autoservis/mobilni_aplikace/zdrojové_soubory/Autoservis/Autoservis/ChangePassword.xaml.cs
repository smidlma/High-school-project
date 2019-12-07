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
    public partial class ChangePassword : ContentPage
    {
        public ChangePassword()
        {
            InitializeComponent();
        }

        private void Button_Clicked(object sender, EventArgs e)
        {
            Navigation.PopModalAsync();
        }

        private async void Button_Clicked_1(object sender, EventArgs e)
        {
            //Změnit heslo
            if (!(String.IsNullOrWhiteSpace(oldPassword.Text)) && !(String.IsNullOrWhiteSpace(newPassword.Text)))
            {
                if (newPassword.Text == confirmPassword.Text)
                {
                    var call = new RestApi();
                    bool response = await call.ChangePassword(newPassword.Text, oldPassword.Text);
                    if (response)
                    {
                        var app = Application.Current as App;
                        await DisplayAlert("Upozornění", "Heslo změněno, budete ohlášen", "OK");
                        Application.Current.Properties.Clear();
                        app.MainPage = new Login();
                    }
                    else
                    {
                        await DisplayAlert("Upozornění", "Zadali jste nesprávné heslo", "OK");
                    }

                }
                else
                {
                    await DisplayAlert("Upozornění", "Zadaná hesla se neschodují", "OK");
                }
            }
            else
            {
                await DisplayAlert("Upozornění", "Vyplňte všechny pole", "OK");
            }

        }


    }
}