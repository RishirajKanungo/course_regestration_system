<?php
        // Start the session
        session_start();

        // Insert the page header
//$page_title = 'Welcome!'
         $pg_title = "Form1";
        require_once('header.php');
        $degreeErr = "";
        require_once('connectvars.php');
        // Show the navigation menu
	require_once('navmenu.php');
?>
<form action="form1back.php" method="post">
   <label for="course1">CourseId 1:</label>
   <input type="number" id="course1" name="course1">
    <label for="cdept1">Course 1 department:</label>
   <input type="text" id="cdept1" name="cdept1"></br>

   <label for="course2">CourseId 2:</label>
   <input type="number" id="course2" name="course2">
   <label for="cdept2">Course 2 department:</label>
   <input type="text" id="cdept2" name="cdept2"></br>

   <label for="course3">CourseId 3:</label>
   <input type="number" id="course3" name="course3">
   <label for="cdept3">Course 3 department:</label>
   <input type="text" id="cdept3" name="cdept3"></br>

   <label for="course4">CourseId 4:</label>
   <input type="number" id="course4" name="course4">
   <label for="cdept4">Course 4 department:</label>
   <input type="text" id="cdept4" name="cdept4"></br>

   <label for="course5">CourseId 5:</label>
   <input type="number" id="course5" name="course5">
   <label for="cdept5">Course 5 department:</label>
   <input type="text" id="cdept5" name="cdept5"></br>

   <label for="course6">CourseId 6:</label>
   <input type="number" id="course6" name="course6">
   <label for="cdept6">Course 6 department:</label>
   <input type="text" id="cdept6" name="cdept6"></br>

   <label for="course7">CourseId 7:</label>
   <input type="number" id="course7" name="course7">
   <label for="cdept7">Course 7 department:</label>
   <input type="text" id="cdept7" name="cdept7"></br>

   <label for="course8">CourseId 8:</label>
   <input type="number" id="course8" name="course8">
   <label for="cdept8">Course 8 department:</label>
   <input type="text" id="cdept8" name="cdept8"></br>

   <label for="course9">CourseId 9:</label>
   <input type="number" id="course9" name="course9">
   <label for="cdept9">Course 9 department:</label>
   <input type="text" id="cdept9" name="cdept9"></br>

   <label for="course10">CourseId 10:</label>
   <input type="number" id="course10" name="course10">
   <label for="cdept10">Course 10 department:</label>
   <input type="text" id="cdept10" name="cdept10"></br>

   <label for="course11">CourseId 11:</label>
   <input type="number" id="course11" name="course11">
   <label for="cdept11">Course 11 department:</label>
   <input type="text" id="cdept11" name="cdept11"></br>

   <label for="course12">CourseId 12:</label>
   <input type="number" id="course12" name="course12">
   <label for="cdept12">Course 12 department:</label>
   <input type="text" id="cdept12" name="cdept12"></br>

   <input type="submit" class="button" name ="submit" value="submit">
 </form>



<?php
  require_once('footer.php');
?>
