<?php
include 'connect.php';
$dayofweek=date("N");
if($dayofweek==5)
{
  //Get meetings and users in them to be notified
  $menteemeetings="SELECT m.meet_id, u.email, u.name from meetings m
  join ((select me.meet_id, me.mentee_id as id from enroll me) union (select me2.meet_id, me2.mentor_id as id from enroll2 me2)) as t on  t.meet_id=m.meet_id
  join users u on t.id=u.id
  where (datediff(m.date, CURDATE()) < 6) and m.meet_id not in (select e.meet_id from enroll e group by e.meet_id
  having count(e.mentee_id)>=3)";

  //Get meetings that have less than 2 mentors and alert the admins
  $mentormeetings="SELECT m.meet_id, u.email, u.name from meetings m
  join admins a on 1=1
  inner join users u on a.admin_id=u.id
  where m.meet_id not in (select e.meet_id from enroll2 e group by e.meet_id having count(e.mentor_id)>=2)
  and datediff(m.date, CURDATE()) < 6";

  //Delete meetings with less than 3 mentees
  $deletemeetings= "DELETE from meetings
  where (datediff(meetings.date, CURDATE()) < 6) and meetings.meet_id
  not in (select e.meet_id from enroll e group by e.meet_id
  having count(e.mentee_id)>=3)";

  $outputf='';
  //create a new file to hold all the emails
  $myfile = fopen("emails.txt", "w");
  file_put_contents('emails.txt', '');
  $menteeresults=(mysqli_query($myconnection, $menteemeetings));
  $outputf= $outputf ."This file follows the following naming convention:" .PHP_EOL
  ."User_ID;EMail;Name;" .PHP_EOL .PHP_EOL
  ."Meetings to cancel due to lack of mentee" .PHP_EOL .PHP_EOL;

  while($row = $menteeresults->fetch_assoc()) {
  $outputf= $outputf .$row["meet_id"]. "; ". $row["email"]. "; " . $row["name"]. "; " .PHP_EOL;
  }
  $outputf= $outputf .PHP_EOL ."Meetings to invite more mentor to" .PHP_EOL .PHP_EOL;;
  $mentorresults=(mysqli_query($myconnection, $mentormeetings));
  while($row = $mentorresults->fetch_assoc()) {
  $outputf= $outputf .$row["meet_id"]. "; ". $row["email"]. "; " . $row["name"]. "; " .PHP_EOL;
  }
  fwrite($myfile, $outputf);
  fclose($myfile);
  //deletes the entries
  mysqli_query($myconnection, $deletemeetings);
}
?>