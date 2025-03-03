

<?php 
// session_start();
// if(!isset($_SESSION['username'])){
// 	header("location: index.php");
// }
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<style>
        *{
            padding: 0;
            margin: 0;
            text-decoration: none;
            box-sizing: border-box;
            list-style: none;
            font-family: sans-serif;

        }
        .wrapper{
            display: flex;
            position: relative;
        }
        .wrapper > .sidebar{
        background-color: black;
        width:200px ;
        height: 100%;
        position: fixed;
        padding: 30px 0px;
        }
        .wrapper > .sidebar >h2{
            color: white;
            margin-bottom: 30px;
            text-transform: uppercase ;
            font-size: 20px ;
            text-align: center;
        }
        .wrapper > .sidebar ul li{
            padding: 18px;

        }
        .wrapper > .sidebar ul li a{
            color: white;
            font-size: 16px;
        }
        .wrapper > .sidebar ul li a:hover{
color: skyblue;

        }
        .wrapper > .sidebar ul li:hover {
background-color: gray;
border-radius: 5px;
        }
.header{
    margin-left: 200px;
    width: 100%;
}
.header > .admin_header{
    background-color: black;
    padding: 15px;
    align-items: center;
    align-self: center;
    width: 100%;
    height: 70PX;
}
.header > .admin_header >a{
    float: right;
    background-color: skyblue;
    padding: 10px;
    border-radius: 15px;
    align-items: center;
    align-self: center;
}
.clearfix::after {
    content: "";
    display: table;
    clear: both;
}

.info{
    padding: 10px;
    margin-top: 30px;
}
.header > .admin_header > h2{
    color: white;
    text-align: center;
    font-size: 20px;
    text-transform: uppercase;
    font-family: sans-serif;
}
.horizontal_panel{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin-top: 20px;
}
.horizontal_inner_panel{
    height: 40px;
    border: 1px solid;
    margin-left: 7px;
    padding: 10px;
    box-shadow: 2px 2px 2px;
    border-radius: 10px;
}

    </style>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <h2> Admin's Panel</h2>
            <ul>
                <li><a href="">Approve PA code</a></li>
                <li><a href="">Vet bills</a></li>
                <li><a href="">Approve Bills</a></li>
                <li><a href="">Request PA code</a></li>
                <li><a href="">Check Hospital List</a></li>
                <li><a href="displayAll.php">Check Enrollees </a></li>
                <li><a href="enrolment.php">Enrolment Form </a></li>
            </ul>
        </div>
        <div class="header">
            <div class="admin_header">
                <h2>Nonsuch Portal Management</h2>
                <a href="">Logout</a>
            </div>
            <div class="horizontal_panel clearfix">
                <div class="horizontal_inner_panel">
                    <a href="">Claims</a>
                </div>
                <div class="horizontal_inner_panel">
                    <a href="">Call Centre</a>
                </div>
                <div class="horizontal_inner_panel">
                    <a href="">Account</a>
                </div>
                <div class="horizontal_inner_panel">
                    <a href="">HR</a>
                </div>
                <div class="horizontal_inner_panel">
                    <a href="">ICT</a>
                </div>
            </div>
            <div class="info clearfix">
                <div><P>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo officiis repellat iure magnam id incidunt iusto eos porro mollitia rem, consectetur totam sunt distinctio velit facere cumque soluta nostrum. Dolor architecto dicta alias temporibus obcaecati sint, perspiciatis iure repellat voluptate, sapiente optio, tempore aut natus iusto tenetur maiores praesentium similique.</P>
                </div>
                  </div>
            
        </div>
       

<!-- <?php include('footer.php'); ?> -->
</body>
</html>