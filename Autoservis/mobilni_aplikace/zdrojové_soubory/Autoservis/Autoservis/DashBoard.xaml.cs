using Autoservis.Class;
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
    public partial class DashBoard : ContentPage
    {
        private RestApi call = new RestApi();
        public DashBoard()
        {
            InitializeComponent();

            //image.Source = ImageSource.FromResource("Autoservis.Images.control-751334_1280.jpg");
            if(Device.RuntimePlatform == Device.iOS)
            {
                //var frame = this.FindByName<Frame>("frameOrder");
                //frame.CornerRadius = 100;
                
            }
                     
        }
        protected override void OnAppearing()
        {
            activityIndicator.IsRunning = true;
            orderListView.BeginRefresh();
            base.OnAppearing();
            orderListView.EndRefresh();
        }
       
        private void Refresh()
        {
            
        }
        private async void OrderListView_ItemSelected(object sender, SelectedItemChangedEventArgs e)
        {
            
            if (e.SelectedItem == null)
                return;

            var item = e.SelectedItem as Order;
            if (item.Stav == "dokončeno")
            {
                var detail = new OrderHistory { Id = item.Id, Auto = item.Auto, Datum = item.Datum };
                await Navigation.PushAsync(new HistoryDetail(detail));
            }
            orderListView.SelectedItem = null;
        }

        private async void OrderListView_Refreshing(object sender, EventArgs e)
        {

            try
            {
                var response = await call.GetOrdersAsync();
                if (response != null)
                {
                    hideListView.IsVisible = false;
                    errorListView.IsVisible = false;

                    orderListView.ItemsSource = response; // OK

                }
                else
                {
                    errorListView.IsVisible = false;

                    hideListView.IsVisible = true; //Empty orders 

                }
            }
            catch
            {
                hideListView.IsVisible = false;
                orderListView.ItemsSource = null;
                orderListView.IsVisible = false;

                errorListView.IsVisible = true;
                activityIndicator.IsRunning = false;    //Conection Error
            }
            orderListView.IsRefreshing = false;
            activityIndicator.IsRunning = false;
        }

        private async void Button_Clicked(object sender, EventArgs e)
        {
            await Navigation.PushAsync(new OrderService());
        }
    }
}