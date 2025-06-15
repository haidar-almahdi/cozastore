<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
            text-decoration: none;
            list-style: none;
        }

        body{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(90deg, #e2e2e2, #c9d6ff);
        }

        .container{
            position: relative;
            width: 850px;
            height: 550px;
            background: #fff;
            margin: 20px;
            border-radius: 30px;
            box-shadow: 0 0 30px rgba(0, 0, 0, .2);
            overflow: hidden;
        }

        .container h1{
            font-size: 36px;
            margin: -10px 0;
        }

        .container p{
            font-size: 14.5px;
            margin: 15px 0;
        }

        .user-info-container {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .form-box{
            position: absolute;
            right: 0;
            width: 50%;
            height: 100%;
            background: #fff;
            display: flex;
            align-items: center;
            color: #333;
            text-align: center;
            padding: 40px;
            z-index: 1;
        }

        .input-box{
            position: relative;
            margin: 30px 0;
        }

        .btn{
            width: 100%;
            height: 48px;
            background: #7494ec;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: #fff;
            font-weight: 600;
            margin: 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-secondary{
            background: #e74c3c;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-box{
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .toggle-box::before{
            content: '';
            position: absolute;
            left: 0;
            width: 50%;
            height: 100%;
            background: #7494ec;
            border-radius: 30px 0 0 30px;
            z-index: 2;
        }

        .toggle-panel{
            position: absolute;
            width: 50%;
            height: 100%;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 2;
        }

        .toggle-panel.toggle-left{
            left: 0;
        }

        .toggle-panel p{
            margin-bottom: 20px;
            font-size: 18px;
        }

        .user-info{
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            width: 100%;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            flex-direction: column;
        }

        .user-info p{
            margin: 10px 0;
            font-size: 16px;
        }

        @media screen and (max-width: 650px){
            .container{
                height: auto;
                min-height: 100vh;
                border-radius: 0;
            }

            .form-box{
                position: relative;
                width: 100%;
                height: auto;
                padding: 20px;
            }

            .toggle-box::before{
                display: none;
            }

            .toggle-panel{
                position: relative;
                width: 100%;
                height: auto;
                color: #333;
                padding: 20px;
            }

            .user-info{
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <div class="user-info-container">
                <h1>Logout</h1>
                <p>Are you sure you want to logout?</p>

                <div class="user-info">
                    <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    @if(Auth::user()->phone)
                        <p><strong>Phone:</strong> {{ Auth::user()->phone }}</p>
                    @endif
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Yes, Logout</button>
                </form>
                <a href="{{ route('shop.home') }}" class="btn">No, Stay Logged In</a>
            </div>
        </div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Goodbye!</h1>
                <p>We hope to see you again soon.</p>
                <p>Thank you for using our service.</p>
            </div>
        </div>
    </div>
</body>
</html>
