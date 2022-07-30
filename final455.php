<!DOCTYPE html>
<html>
<head>
    <?php
include 'dbConn.php';
$conn = OpenCon();
echo "Connected Successfully";
CloseCon($conn);
?>
<style>
    button{
        background-color: Transparent;
        height:20px; 
    width:100px; 
    margin-bottom: 100px; 
    position:center;
    }
.grid-container {
  display: grid;
  grid-template-columns: 80px 200px 40px 200px 40px 200px 40px 200px 40px 200px 80px;
  grid-template-rows: 40px 100px 40px 60px 40px 50px 50px 50px 50px 50px 50px 50px 50px 50px 200px 50px 50px 50px 100px;
  

  padding: 10px;
}
    body{
        background-image: url("https://images5.alphacoders.com/808/808254.jpg");
  background-position: center; /* Center the image */
  background-repeat:none ; /* Do not repeat the image */
  
    }

.grid-container > div {
  background-color: rgba(255, 255, 255, 0.8);
  text-align: center;
  padding: 20px 0;
  font-size: 30px;
}
.header{
	grid-row: 2/3;
    grid-column: 2/11;
   border-style: solid;
  border-width: 5px;
 border-radius:20px;
}
.b1{
	grid-row: 4/5;
    grid-column: 2/3;
border-style: solid;
  border-width: 5px;
 border-radius:20px;
}
.b2{
	grid-row: 4/5;
    grid-column: 4/5;
border-style: solid;
  border-width: 5px;
 border-radius:20px;
}
.b3{
	grid-row: 4/5;
    grid-column: 6/7;
border-style: solid;
  border-width: 5px;
 border-radius:20px;
}
.b4{
	grid-row: 4/5;
    grid-column: 8/9;border-style: solid;
  border-width: 5px;
 border-radius:20px;
}
.b5{
	grid-row: 4/5;
    grid-column: 10/11;
border-style: solid;
  border-width: 5px;
 border-radius:20px;
}
.b1:hover{
  background-color: rgba(218,112,214, 0.8);
  
}
.b2:hover{
  background-color: rgba(218,112,214, 0.8);
  
}
.b3:hover{
  background-color: rgba(218,112,214, 0.8);
  text-align: center;
  
}
.b4:hover{
  background-color: rgba(218,112,214, 0.8);
  
}
.b5:hover{
  background-color: rgba(218,112,214, 0.8);
  
}


#bodyCat{
	grid-row: 6/18;
    grid-column: 2/11;
border-width: 5px;
 border-radius:90px;
  visibility: hidden;
}
#bodyEmp{
	grid-row: 6/18;
    grid-column: 2/11;
border-width: 5px;
 border-radius:90px;
  visibility: hidden;
}
#bodyCurrent{
	grid-row: 6/18;
    grid-column: 2/11;
border-width: 5px;
 border-radius:90px;
  visibility: hidden;
}
#bodySearch{
	grid-row: 6/18;
    grid-column: 2/11;
border-width: 5px;
 border-radius:90px;
  visibility: hidden;
}
#bodyRent {
grid-row: 6/18;
    grid-column: 2/11;
  border-width: 5px;
 border-radius:90px;
}


</style>
</head>
<body>


<div class="grid-container">
    <div class="header">Library Database System</div>
  


<div class="b1"><button onclick="myFunction1()">Rent</button></div>

  <div class="b2"><button onclick="myFunction2()">Catalog</button></div>
  <div class="b3"><button onclick="myFunction3()">Emp./Memb.</button></div>  
  <div class="b4"><button onclick="myFunction4()">Rentals</button></div>
  <div class="b5"><button onclick="myFunction5()">Search</button></div>


  
  <div id="bodyRent">
<form method="post">
<div class="R_label1">Member ID:</div>
<div class="R_textbox1"><input type="text" name="Member_id"></div>

<div class="R_label2">Book Title:</div>
<div class="R_textbox2"><input type="text" name="Book_title"></div>
<input type="submit"  name="rent" value="Rent Book"/>
    <br>
    <br>
     <br>
<div class="R_label2">Copy_ID:</div>
<div class="R_textbox2"><input type="text" name="Copy_id"></div>
<input type="submit"  name="return" value="Return Book"/>
   
    <?php	
    $conn = OpenCon();
    
    if(isset($_POST['return']))
    {
        $id=$_POST['Copy_id'];
        $query1 = "Select * from lend_record where copy_id='$id' and returned=0";
        $query2 = "Select member_id from lend_record where lend_record.copy_id='$id'";
        $result1=$conn->query($query1);
        $member=$conn->query($query2);
        
        
        $numOf = mysqli_num_rows($result1);
    $row = mysqli_fetch_array($result1);
    $row2 = mysqli_fetch_array($member);
        $member = $row2[0];
    if ($numOf == 0) {
        
  echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>
Sorry; no records of that copy being rented
</textarea></div>";
}
      else {
            $today = date("Y/m/d");
            $updateQuery3 = "UPDATE lend_record
SET returned = 1
WHERE lend_record.copy_id='$id'";
            
            $updateQueryAvail = "UPDATE book_copy
SET available = 1
WHERE copy_id='$id'";
            $updateReturned=$conn->query($updateQuery3);
            $updateReturned=$conn->query($updateQueryAvail);
            while($row = mysqli_fetch_array($result1)) {
                $returnedDate = $row[0];
            }
          $returnedDate = $row[0];
            if($today < $returnedDate) {
               $updateQuery = "UPDATE member
SET charges = charges + 10
WHERE member.member_id='$member'";
                $updateQuery2 = "UPDATE lend_record
SET late_charge_added = 1
WHERE lend_record.copy_id='$id'";
                $update=$conn->query($updateQuery);
                $updated=$conn->query($updateQuery2);
                echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>
Thanks for returning your book LATE!!!
</textarea></div>";
            }else{
                echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>
Thanks for returning your book on time!
</textarea></div>";
            }
                // Print the entire row data
        }     
    }
    CloseCon($conn);
    ?>
    
    
    <?php	
    $conn = OpenCon();
if(isset($_POST['rent']))
{
$id=$_POST['Member_id'];		
$book=$_POST['Book_title'];				
$query1 = "Select book.title from book, book_copy where book.title='$book'";
$query2 = "Select member.member_id from member where member.member_id='$id'";
$result1=$conn->query($query1);
$result2=$conn->query($query2);
$finalResult = "hi";
$numResults1 = mysqli_num_rows($result1);
    $numResults2 = mysqli_num_rows($result2);
if ($numResults1 == 0) {
  echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>
Invalid data; book not found
</textarea></div>";
}
else if($numResults2 == 0) {
    echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>
Invalid data; member not found
</textarea></div>";
    
}else{
    $copyQuery = "select copy_id from book_copy where book_copy.available = 1 and book_copy.title='$book' LIMIT 11";
    $result=$conn->query($copyQuery);
    $numOf = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    
    if ($row[0] == '') {
        echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>
Sorry; were are out of that book
</textarea></div>";
    }
    else{
    
         $copyId = $row[0];       // Print the entire row data

        $startDate = date("Y-m-d");
        $returnDate= date('Y-m-d', strtotime("+30 days"));
    $rentInsert = "INSERT INTO lend_record (Copy_id, End_date, Late_charge_added, Member_id, returned, Start_date) 
VALUES ('$copyId', '$returnDate', 0, '$id', 0, '$startDate')";
        if ($conn->query($rentInsert) == TRUE) {
    
}else{
    echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>
Record not successfully updated!
</textarea></div>";
        }
        echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>
Dont lose this info!     copy_id: '$copyId'     Return date: '$returnDate'   
</textarea></div>";
        
       $updateQuery2 = "UPDATE book_copy
SET available = 0
WHERE book_copy.copy_id='$copyId'";
        $result=$conn->query($updateQuery2);
    }
} 

    CloseCon($conn);
}
?>
    
    
<br>


</form>
</div>



  <div id="bodyCat">
      <form method="post">
      
  
<div class="R_label1">By genre:</div>
<div class="R_textbox1"><select name="genre">
    <option value="fantasy">fantasy</option>
    <option value="biographical">biographical</option>
    <option value="drama">drama</option>
    <option value="educational">educational</option>
    <option value="romantic">romantic</option>
    <option value="historical">historical</option>
  </select></div>
      <input type="submit"  name="GenreReturn" value="Submit Genre"/>
<br>
          
          
          <?php 
      $conn = OpenCon();
      
      if(isset($_POST['GenreReturn']))
      {
         $selectOption = $_POST['genre']; 
          $genreQuery = "Select * from book where book.genre='$selectOption'";
         $result=$conn->query($genreQuery);
          echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>";
              while($row = mysqli_fetch_array($result)) {
                print_r ($row);
            }
          echo "</textarea></div>";
      }
      CloseCon($conn);
      ?>
      
          
<div class="R_label2">By author:</div>
<div class="R_textbox2"><input type="text" name="AuthorChoice"></div>
<input type="submit"  name="ByAuthor" value="Submit By Author"/>
                 <br>
         
<?php 
      $conn = OpenCon();
      
      if(isset($_POST['ByAuthor']))
      {
         $selectOption = $_POST['AuthorChoice']; 
          $genreQuery = "Select * from author where author.author_name='$selectOption'";
         $result=$conn->query($genreQuery);
          echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>";
              $row = mysqli_fetch_array($result);
print_r ($row);
            
          echo "</textarea></div>";
      }
      CloseCon($conn);
      ?>          
          
          
<div class="R_label2">By title:</div>
<div class="R_textbox2"><input type="text" name="Title"></div>
<input type="submit"  name="ByTitle" value="Submit By Title"/>
          <br>
          <br>
         
<?php 
      $conn = OpenCon();
      
      if(isset($_POST['ByTitle']))
      {
         $selectOption = $_POST['Title']; 
          $genreQuery = "Select * from book where book.title='$selectOption'";
         $result=$conn->query($genreQuery);
          echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>";
              $row = mysqli_fetch_array($result);
print_r ($row);
            
          echo "</textarea></div>";
      }
      CloseCon($conn);
      ?>           
          
<div class="R_label2">Pre-built searches</div>
<div class="R_textbox2"><select name="views">
    <option value="long_books">Books longer that 100 pages</option>
    <option value="available_books">Books available</option>

  </select></div>

<input type="submit"  name="ByView" value="Submit By View"/>
          <?php 
      $conn = OpenCon();
      
      if(isset($_POST['ByView']))
      {
         $selectOption = $_POST['views']; 
          //print($selectOption);
          $genreQuery = "Select * from $selectOption";
         $result=$conn->query($genreQuery);
         // $result = mysqli_query($conn,$genreQuery);
          echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>";
             while($row = mysqli_fetch_array($result)) {
          //$row = mysqli_fetch_array($result);      
          print_r ($row);
             }
          echo "</textarea></div>";
      }
      CloseCon($conn);
      ?>
          
<input type="submit"  name="AllBooks" value="See all books"/>
<?php 
      $conn = OpenCon();
      
      if(isset($_POST['AllBooks']))
      { 
          //print($selectOption);
          $genreQuery = "Select * from book";
         $result=$conn->query($genreQuery);
         // $result = mysqli_query($conn,$genreQuery);
          echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>";
             while($row = mysqli_fetch_array($result)) {
          //$row = mysqli_fetch_array($result);      
          print_r ($row);
             }
          echo "</textarea></div>";
      }
      CloseCon($conn);
      ?>

<br>


</form>

</div>

  <div id="bodyEmp">
      <form method="post">
<input type="submit"  name="AllEmp" value="See All Employees"/>
<?php 
      $conn = OpenCon();
      
      if(isset($_POST['AllEmp']))
      { 
          //print($selectOption);
         // $selectOption = $_POST['viewsOver'];
          $genreQuery = "Select * from Employee";
         $result=$conn->query($genreQuery);
         // $result = mysqli_query($conn,$genreQuery);
          echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>";
             while($row = mysqli_fetch_array($result)) {
          //$row = mysqli_fetch_array($result);      
          print_r ($row);
             }
          echo "</textarea></div>";
      }
      CloseCon($conn);
      ?>
          
          
<input type="submit"  name="AllMemb" value="See All Members"/>
          <br>
          <br>
          <br>
<?php 
      $conn = OpenCon();
      
      if(isset($_POST['AllMemb']))
      { 
          //print($selectOption);
         // $selectOption = $_POST['viewsOver'];
          $genreQuery = "Select * from Member";
         $result=$conn->query($genreQuery);
         // $result = mysqli_query($conn,$genreQuery);
          echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>";
             while($row = mysqli_fetch_array($result)) {
          //$row = mysqli_fetch_array($result);      
          print_r ($row);
             }
          echo "</textarea></div>";
      }
      CloseCon($conn);
      ?>
          
          
<div class="R_label2">Pre-built searches</div>
<div class="R_textbox2"><select name="viewsOver">
    <option value="Members_with_charges">Members with late charges</option>
    <option value="member_with_overdue_books">Members with overdue books</option>
  </select></div>
      <input type="submit"  name="MemberView" value="See View"/>
      <?php 
      $conn = OpenCon();
      
      if(isset($_POST['MemberView']))
      { 
          //print($selectOption);
          $selectOption = $_POST['viewsOver'];
          $genreQuery = "Select * from $selectOption";
         $result=$conn->query($genreQuery);
         // $result = mysqli_query($conn,$genreQuery);
          echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>";
             while($row = mysqli_fetch_array($result)) {
          //$row = mysqli_fetch_array($result);      
          print_r ($row);
             }
          echo "</textarea></div>";
      }
      CloseCon($conn);
      ?>

          <br>
          <br>
          Add Member:
          <br>
          Name:
          <input type="text" name="NameAddMember">
          <input type="submit"  name="AddMemberSubmit" value="Submit Add Member"/>
          <br>
        <?php 
          $conn = OpenCon();
          if(isset($_POST['AddMemberSubmit']))
            {
              $Name=$_POST['NameAddMember'];
              $id="M";
              $theNum= strval(rand(10,100));
              $id .= $theNum;
              $addStatement="Insert into member (member_id, charges, name) values ('$id', 0, '$Name')";
              $result=$conn->query($addStatement);
          }
              CloseCon($conn);
          ?>
          
          
          <br>
          Add Employee:
          <br>
          Name:
          <input type="text" name="NameAddEmp">
          <input type="submit"  name="AddEmpSubmit" value="Submit Add Emp"/>
        <?php 
          $conn = OpenCon();
          if(isset($_POST['AddEmpSubmit']))
            {
              $startDate = date("Y-m-d");;
              $Name=$_POST['NameAddEmp'];
              $id="E";
              $theNum= strval(rand(10,100));
              $id .= $theNum;
              $addStatement="Insert into employee (employee_id, charges, name, start_date) values ('$id', 0, '$Name', '$startDate')";
              $result=$conn->query($addStatement);
          }
              CloseCon($conn);
          ?>
          
      </form>  
</div>


  <div id="bodyCurrent">
      <form method="post">
      
          <input type="submit"  name="CurrentCharges" value="Show outstanding charges"/>
          <?php 
      $conn = OpenCon();
      
      if(isset($_POST['CurrentCharges']))
      { 
          //print($selectOption);
          $genreQuery = "Select * from member where charges > 0";
         $result=$conn->query($genreQuery);
         // $result = mysqli_query($conn,$genreQuery);
          echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>";
             while($row = mysqli_fetch_array($result)) {
          //$row = mysqli_fetch_array($result);      
          print_r ($row);
             }
          echo "</textarea></div>";
      }
      CloseCon($conn);
      ?>
          
          
      <input type="submit"  name="CurrentRent" value="Current Rentals"/>
          <?php 
      $conn = OpenCon();
      
      if(isset($_POST['CurrentRent']))
      { 
          //print($selectOption);
          $genreQuery = "Select * from lend_record where returned=0";
         $result=$conn->query($genreQuery);
         // $result = mysqli_query($conn,$genreQuery);
          echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>";
             while($row = mysqli_fetch_array($result)) {
          //$row = mysqli_fetch_array($result);      
          print_r ($row);
             }
          echo "</textarea></div>";
      }
      CloseCon($conn);
      ?>
          
<br>

<br>
Make a Payment:
<div class="R_label2">Member ID:</div>
<div class="R_textbox2"><input type="text" name="membId"></div>
<div class="R_label2">Amount:</div>
<div class="R_textbox2"><input type="text" name="amount"></div>
<input type="submit"  name="Payment" value="Submit Payment"/>

          <?php 
          $conn = OpenCon();
          if(isset($_POST['Payment']))
            {
              $id=$_POST['membId'];
              $amount=$_POST['amount'];
              if(is_numeric($amount)) {
              $checkquery = "select * from member where member_id='$id'";
                $result=$conn->query($checkquery);
                $numOf = mysqli_num_rows($result);
   
    if ($numOf == 0) {
                echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>
    Cant find that member
</textarea></div>"; 
              }else {
        $findCurrent = "Select charges from member where member_id='$id'";
        $result=$conn->query($checkquery);
        
        $updateCharge = "UPDATE member
SET charges = charges - $amount
WHERE lend_record.copy_id='$id'";
        $result=$conn->query($checkquery);
            $updateCharge = "UPDATE member
SET charges = 0
WHERE charges < 0";
        $result=$conn->query($checkquery);
        }
        
        echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>
    Thanks for Payment!!
</textarea></div>"; 
    }
            else {
                  echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>
    Please enter a numeric value for charges
</textarea></div>"; 
              }
          }
          
              CloseCon($conn);
          ?>
      </form>
</div>
   
  <div id="bodySearch">
<form method="post">
<div class="R_label2">Tables</div>
<div class="R_textbox2"><select name="tables">
    <option value="author">author</option>
    <option value="book">book</option>
    <option value="book_copy">book_copy</option>
    <option value="employee">employee</option>
    <option value="lend_record">lend_record</option>
    <option value="member">member</option>
    <option value="publisher">publisher</option>
    
    
  </select></div>
    <input type="submit"  name="tablesSubmit" value="Submit table view"/>
    <br>
          <br>
          <br>
<?php 
      $conn = OpenCon();
      
      if(isset($_POST['tablesSubmit']))
      { 
          //print($selectOption);
          $selectOption = $_POST['tables'];
          $genreQuery = "Select * from $selectOption";
         $result=$conn->query($genreQuery);
         // $result = mysqli_query($conn,$genreQuery);
          echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>";
             while($row = mysqli_fetch_array($result)) {
          //$row = mysqli_fetch_array($result);      
          print_r ($row);
             }
          echo "</textarea></div>";
      }
      CloseCon($conn);
      ?>
    
    
<div class="R_label2">Pre-built searches</div>
<div class="R_textbox2"><select name="Previews">
    <option value="available_books">Available books</option>
    <option value="unavailable_books">Unavailable books</option>
  </select></div>
    <input type="submit"  name="ViewSubmit" value="Submit View"/>
    <br>
          <br>
          <br>

    <?php 
      $conn = OpenCon();
      
      if(isset($_POST['ViewSubmit']))
      { 
          //print($selectOption);
          $selectOption = $_POST['Previews'];
          $genreQuery = "Select * from $selectOption";
         $result=$conn->query($genreQuery);
         // $result = mysqli_query($conn,$genreQuery);
          echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>";
             while($row = mysqli_fetch_array($result)) {
          //$row = mysqli_fetch_array($result);      
          print_r ($row);
             }
          echo "</textarea></div>";
      }
      CloseCon($conn);
      ?>
    
   <div class="R_label2">Custom SQL search</div>
    <input type="text" name="SQLText">
<input type="submit"  name="SQL" value="Submit SQL"/>
    <?php 
      $conn = OpenCon();
      
      if(isset($_POST['SQL']))
      { 
          //print($selectOption);
          $genreQuery = $_POST['SQLText'];
         $result=$conn->query($genreQuery);
         // $result = mysqli_query($conn,$genreQuery);
          echo "<br>Result:<br><br>
<div class='result'><textarea rows='8' cols='100'>";
             while($row = mysqli_fetch_array($result)) {
          //$row = mysqli_fetch_array($result);      
          print_r ($row);
             }
          echo "</textarea></div>";
      }
      CloseCon($conn);
      ?>
    
      </form>
    </div>

</div>


<script>
function myFunction1() {
  var x = document.getElementById('bodyRent');
  var y = document.getElementById('bodyCat');
  var z = document.getElementById('bodyEmp');
  var a = document.getElementById('bodyCurrent');
  var b = document.getElementById('bodySearch');
  x.style.visibility = 'visible';
  
    y.style.visibility = 'hidden';
   z.style.visibility = 'hidden';
   a.style.visibility = 'hidden';
   b.style.visibility = 'hidden';
  
}
function myFunction2() {
  var x = document.getElementById('bodyRent');
  var y = document.getElementById('bodyCat');
  var z = document.getElementById('bodyEmp');
  var a = document.getElementById('bodyCurrent');
  var b = document.getElementById('bodySearch');
  y.style.visibility = 'visible';
  
    x.style.visibility = 'hidden';
   z.style.visibility = 'hidden';
   a.style.visibility = 'hidden';
   b.style.visibility = 'hidden';
 
}
function myFunction3() {
  var x = document.getElementById('bodyRent');
  var y = document.getElementById('bodyCat');
  var z = document.getElementById('bodyEmp');
  var a = document.getElementById('bodyCurrent');
  var b = document.getElementById('bodySearch');
  z.style.visibility = 'visible';
  
    x.style.visibility = 'hidden';
   y.style.visibility = 'hidden';
   a.style.visibility = 'hidden';
   b.style.visibility = 'hidden';
 
}
function myFunction4() {
  var x = document.getElementById('bodyRent');
  var y = document.getElementById('bodyCat');
  var z = document.getElementById('bodyEmp');
  var a = document.getElementById('bodyCurrent');
  var b = document.getElementById('bodySearch');
  a.style.visibility = 'visible';
  
    x.style.visibility = 'hidden';
   z.style.visibility = 'hidden';
   y.style.visibility = 'hidden';
   b.style.visibility = 'hidden';
 
}
function myFunction5() {
  var x = document.getElementById('bodyRent');
  var y = document.getElementById('bodyCat');
  var z = document.getElementById('bodyEmp');
  var a = document.getElementById('bodyCurrent');
  var b = document.getElementById('bodySearch');
  b.style.visibility = 'visible';
  
    x.style.visibility = 'hidden';
   z.style.visibility = 'hidden';
   a.style.visibility = 'hidden';
   y.style.visibility = 'hidden';
 
}



</script>
</body>
</html>
