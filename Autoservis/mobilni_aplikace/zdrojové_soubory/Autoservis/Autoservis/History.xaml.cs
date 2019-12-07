using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace Autoservis
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class History : ContentPage
    {
       private RestApi call = new RestApi();

        public History()
        {
            InitializeComponent();

        }
        protected override void OnAppearing()
        {
           
            activityIndicator.IsRunning = true;
            searchBar.IsVisible = false;
            historyListView.IsVisible = false;
            historyListView.BeginRefresh();
            base.OnAppearing();
            historyListView.EndRefresh();
        }

        private async void HistoryListView_ItemSelected(object sender, SelectedItemChangedEventArgs e)
        {
            if (e.SelectedItem == null)
                return;
            var historyDetail = e.SelectedItem as OrderHistory;
            await Navigation.PushAsync(new HistoryDetail(historyDetail));
            historyListView.SelectedItem = null;
        }

        private async void SearchBar_TextChanged(object sender, TextChangedEventArgs e)
        {
            historyListView.ItemsSource = await call.GetOrderHistoriesAsync(e.NewTextValue);
        }

        private async void HistoryListView_Refreshing(object sender, EventArgs e)
        {
            try
            {
                errorListView.IsVisible = false;

                historyListView.ItemsSource = await call.GetOrderHistoriesAsync();
                searchBar.IsVisible = true;
                historyListView.IsVisible = true;
                activityIndicator.IsVisible = false;
            }
            catch
            {
                historyListView.ItemsSource = null;
                errorListView.IsVisible = true;
                activityIndicator.IsRunning = false;
                searchBar.IsVisible = false;

            }

            historyListView.EndRefresh();
            activityIndicator.IsRunning = false;

        }
    }



}

