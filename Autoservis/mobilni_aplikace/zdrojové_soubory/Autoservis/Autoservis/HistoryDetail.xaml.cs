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
    public partial class HistoryDetail : ContentPage
    {
        private OrderHistory Order;
        
        public HistoryDetail(OrderHistory orderHistory)
        {
            if (orderHistory == null)
                throw new ArgumentNullException();
            
            
            InitializeComponent();
            this.Order = orderHistory;
            Title = Order.Datum.ToString("dd/MM/yyyy") + " " + Order.Auto.ToString();
        }
        protected override async void OnAppearing()
        {
            var call = new RestApi();
            try {
                activityIndicator.IsRunning = true;
                detailListView.ItemsSource = await call.GetOrderDetailsAsync(Order.Id);
                activityIndicator.IsRunning = false;
                activityIndicator.IsVisible = false;
            }
            catch
            {
               await DisplayAlert("Error", "Připojení k servru selhalo", "OK");
                Navigation.RemovePage(this);
            }


            base.OnAppearing();
        }

        private void DetailListView_ItemSelected(object sender, SelectedItemChangedEventArgs e)
        {
            detailListView.SelectedItem = null;
        }
    }
}