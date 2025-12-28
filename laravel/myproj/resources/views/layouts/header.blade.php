<table width="100%" bgColor="orange" class="header">
        <tr align="center">
            <td width="20%" class="imgset">
                <div>

                    <img src="img/college.jpg" alt="Image" width="100%">
                </div>
                <div>

                    <img src="img/User.jpeg" alt="Image" width="100%">
                </div>
                <div>

                    <img src="img/rahul.jpg" alt="Image" width="100%">
                </div>
                <div>

                    <img src="img/arun.jpg" alt="Image" width="100%">
                </div>
            </td>
            <td width="80%" align="center">
                <h1 bgColor="orange">Welcome to Government MCA College, Maninagar</h1>
                <h3>GROUP NO : 17</h3>

            </td>
        </tr>
</table>
<table width="100%" bgColor="grey" class="header">
        <tr align="center">
            <td>
                <p><a href='{{route("home")}}'>Home</a> | 
                   <a href="#">About Us</a> | 
                   <a href="#">Services</a> | 
                   <a href="#">Contact</a> |
                   @if(session()->has('user_id'))
                   <a href='{{route('calculator')}}'>calculator</a> |
                   <a href='{{route('jobApplication.list')}}'>Application</a> |
                   <a href='{{route('logout')}}'>Logout</a>
                   @else
                   <a href='{{route('login')}}'>Login</a>
                   @endif
                </p>
            </td>
        </tr>
</table>