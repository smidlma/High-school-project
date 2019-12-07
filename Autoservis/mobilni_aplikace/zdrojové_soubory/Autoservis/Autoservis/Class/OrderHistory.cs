using System;
using System.Collections.Generic;
using System.Text;

namespace Autoservis
{
   public class OrderHistory
    {
        public int Id { get; set; }
        public DateTime Datum { get; set; }
        public string Auto { get; set; }
        public int Cena { get; set; }
    }
}
