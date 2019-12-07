using Autoservis.Class;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using Xamarin.Forms;

namespace Autoservis
{
    public class RestApi
    {

        private HttpClient client = new HttpClient();
        //private string webAdress = "http://localhost/Api/api/";
        private string webAdress = "http://mujautoservis.8u.cz/";
        private App app = Application.Current as App;

        public async Task<bool> Login(string email, string password)
        {
            var user = new User { Email = email, Password = password };
            var content = JsonConvert.SerializeObject(user);
            var responseMessage = await client.PostAsync(webAdress + "Api/api/user/login.php", new StringContent(content, Encoding.UTF8, "application/json"));
            if (responseMessage.IsSuccessStatusCode)
            {
                var response = JsonConvert.DeserializeObject<User>(await responseMessage.Content.ReadAsStringAsync());
                if (response.Token != "")
                {
                    app.Token = response.Token;
                    app.ExpireDate = response.Date;
                }
                return true;
            }
            return false;
        }

        public async Task<bool> ChangePassword(string newPassword, string oldPassword)
        {
            var user = new User { Token = app.Token, Password = oldPassword, NewPassword = newPassword };
            var content = JsonConvert.SerializeObject(user);
            var responseMessage = await client.PostAsync(webAdress + "Api/api/user/changePassword.php", new StringContent(content, Encoding.UTF8, "application/json"));
            if (responseMessage.IsSuccessStatusCode)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public async Task<IEnumerable<OrderHistory>> GetOrderHistoriesAsync(string searchText = null)
        {

            var user = new User { Token = app.Token };
            var content = JsonConvert.SerializeObject(user);
            var responseMessage = await client.PostAsync(webAdress + "Api/api/order/readHistory.php", new StringContent(content, Encoding.UTF8, "application/json"));
            if (responseMessage.IsSuccessStatusCode)
            {
                var response = JsonConvert.DeserializeObject<IEnumerable<OrderHistory>>(await responseMessage.Content.ReadAsStringAsync());
                if (String.IsNullOrWhiteSpace(searchText))
                    return response;

                return response.Where(c => (c.Datum.ToShortDateString().Contains(searchText)) ||
                (c.Auto.ToLower().Contains(searchText.ToLower())) || (c.Cena.ToString().Contains(searchText)));

            }
            return null;
        }

        public async Task<List<OrderHistoryDetail>> GetOrderDetailsAsync(int id)
        {

            var user = new User { Token = app.Token, Id = id };
            var content = JsonConvert.SerializeObject(user);
            var responseMessage = await client.PostAsync(webAdress + "Api/api/order/readDetail.php",
                new StringContent(content, Encoding.UTF8, "application/json"));
            if (responseMessage.IsSuccessStatusCode)
            {
                var response = JsonConvert.DeserializeObject<List<OrderHistoryDetail>>(await responseMessage.Content.ReadAsStringAsync());
                return response;
            }
            return null;
        }

        public async Task<List<Order>> GetOrdersAsync()
        {


            var user = new User { Token = app.Token };
            var content = JsonConvert.SerializeObject(user);
            var responseMessage = await client.PostAsync(webAdress + "Api/api/order/read.php",
                new StringContent(content, Encoding.UTF8, "application/json"));
            if (responseMessage.IsSuccessStatusCode)
            {
                var response = JsonConvert.DeserializeObject<List<Order>>(await responseMessage.Content.ReadAsStringAsync());
                return response;

            }
            return null;

        }

        public async Task<IList<Car>> GetCarsAsync()
        {
            var user = new User { Token = app.Token };
            var content = JsonConvert.SerializeObject(user);
            var responseMessage = await client.PostAsync(webAdress + "Api/api/order/readCars.php",
                new StringContent(content, Encoding.UTF8, "application/json"));
            if (responseMessage.IsSuccessStatusCode)
            {
                var response = JsonConvert.DeserializeObject<List<Car>>(await responseMessage.Content.ReadAsStringAsync());
                return response;

            }
            return null;
        }

        public async Task<bool> AddOrderAsync(int Id, DateTime Datum, string Zavada)
        {

            
            var user = new User { Token = app.Token, Date = Datum.ToString("yyyy-MM-dd"), Id = Id, Zavada = Zavada };
           
            var content = JsonConvert.SerializeObject(user);
            var responseMessage = await client.PostAsync(webAdress + "Api/api/order/create.php",
                new StringContent(content, Encoding.UTF8, "application/json"));
            if (responseMessage.IsSuccessStatusCode)
            {
                return true;

            }
            return false;

        }

        public async Task<UserInfo> GetUserInfoAsync()
        {

            var user = new User { Token = app.Token };
            var content = JsonConvert.SerializeObject(user);
            var responseMessage = await client.PostAsync(webAdress + "Api/api/user/userInfo.php",
                new StringContent(content, Encoding.UTF8, "application/json"));
            if (responseMessage.IsSuccessStatusCode)
            {
                var response = JsonConvert.DeserializeObject<UserInfo>(await responseMessage.Content.ReadAsStringAsync());
                return response;

            }
            return null;

        }
    }
}
