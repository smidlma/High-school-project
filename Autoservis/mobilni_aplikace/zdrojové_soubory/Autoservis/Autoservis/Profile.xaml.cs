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
    public partial class Profile : ContentPage
    {
        RestApi call = new RestApi();
        public Profile()
        {
            InitializeComponent();

        }
        protected override async void OnAppearing()
        {
            try {
                userInfo.BindingContext = await call.GetUserInfoAsync();
            }
            catch {
                await DisplayAlert("Error", "Chyba připojení", "OK");
                await Navigation.PopModalAsync();
            }
            base.OnAppearing();
        }

        private void Button_Clicked(object sender, EventArgs e)
        {
            Navigation.PopModalAsync();
        }

        // Upravit Profil
        private async void Button_Clicked_1(object sender, EventArgs e)
        {
            await DisplayAlert("Upozornění", "Pro úpravu kontaktních údajů použijte stránky Autoservisu", "OK");
        }

        // Změnit heslo
        private async void Button_Clicked_2(object sender, EventArgs e)
        {
            await Navigation.PushModalAsync(new ChangePassword());
        }
    }
}