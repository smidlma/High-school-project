using System;
using System.Collections.Generic;
using System.Text;

namespace Autoservis.Class
{
    public static class DateTimeHelper
    {
        public static DateTime Tomorrow
        {
            get { return DateTime.Today.AddDays(1); }
        }
    }
}
