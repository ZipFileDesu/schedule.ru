<?php

class database
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function getAllStudents(){
        $data = [];
        $result = pg_query($this->con, "SELECT concat(t1.\"First_Name\", ' ', t1.\"Last_Name\", ' ', t1.\"Middle_Name\"), 
            t2.\"Name\", t1.id FROM public.\"Students\" AS t1 INNER JOIN public.\"Groups\" AS t2 ON t1.\"Group_id\"= t2.Id");
        while ($row = pg_fetch_row($result)) {
            $data[] = ['name' => $row[0], 'group' => $row[1], 'id' =>$row[2] ];
        }
        return $data;
    }

    public function getStudentsByGroup($id){
        $data = [];
        $result = pg_query($this->con, "SELECT concat(t1.\"First_Name\", ' ', t1.\"Last_Name\", ' ', t1.\"Middle_Name\"), 
            t2.\"Name\", t1.id FROM public.\"Students\" AS t1 INNER JOIN public.\"Groups\" AS t2 ON t1.\"Group_id\"= t2.Id
            WHERE t1.\"Group_id\" = '$id'");
        while ($row = pg_fetch_row($result)) {
            $data[] = ['name' => $row[0], 'group' => $row[1], 'id' => $row[2]];
        }
        return $data;
    }

    public function getStudentById($id){
        $data = [];
        $result = pg_query($this->con, "SELECT concat(t1.\"First_Name\", ' ', t1.\"Last_Name\", ' ', t1.\"Middle_Name\"), t1.id,
            t2.\"Name\", t5.\"Name\", t4.\"Text\", t3.\"mark\" FROM public.\"Students\" AS t1 
			INNER JOIN public.\"Groups\" AS t2 ON t1.\"Group_id\"= t2.Id
			INNER JOIN public.\"Marks\" AS t3 ON t1.\"id\" = t3.\"student_id\"
			INNER JOIN public.\"Tasks\" AS t4 ON t3.\"task_id\" = t4.\"id\"
			INNER JOIN public.\"Subjects\" AS t5 ON t4.\"subject_id\" = t5.\"id\"
			WHERE t1.id = $id");
        while ($row = pg_fetch_row($result)) {
            $data[] = ['name' => $row[0], 'group' => $row[1], 'id' => $row[2], 'subject_name' => $row[3],
                'task_text' => $row[4], 'mark' => $row[5]];
        }
        return $data;
    }

    public function insertStudent($firstName, $lastName, $middleName, $groupId){
        $result = pg_query($this->con, "INSERT INTO public.\"Students\" 
            (\"First_Name\", \"Last_Name\", \"Middle_Name\", \"Group_id\")
            VALUES ('$firstName', '$lastName', '$middleName', '$groupId') RETURNING id");
        $result = pg_fetch_array($result);
        if ($result){
            pg_query($this->con, "
            DO
            \$do\$
                DECLARE 
	                i bigint;
            BEGIN
	            FOR i iN 1..(SELECT COUNT(*) FROM public.\"Tasks\") LOOP
		            INSERT INTO public.\"Marks\" (student_id, task_id, mark) VALUES ($result[id], i, null);
	            END LOOP;
            END
            \$do\$
            LANGUAGE plpgsql;");
            return constants::studentSuccessfullInsert;
        }
        else{
            return constants::studentFailedInsert;
        }
    }

    public function getAllGroups(){
        $data = [];
        $result = pg_query($this->con, "SELECT * FROM public.\"Groups\"");
        while ($row = pg_fetch_row($result)) {
            $data[] = ['id' => $row[0] ,'name' => $row[1]];
        }
        return $data;
    }

    public function getSchedule($id){
        $data = [];
        $result = pg_query($this->con, "SELECT concat(t5.\"Start_time\", '-', t5.\"End_time\") \"Pair_time\", t1.\"Date\", t6.\"Name\", t3.\"Name\",
            concat(t4.\"First_Name\", ' ', t4.\"Last_Name\", ' ', t4.\"Middle_Name\") AS \"Professor_name\", t2.\"Name\" FROM public.\"Schedule\" AS t1
            INNER JOIN public.\"Groups\" AS t2 ON t1.\"Group_id\" = t2.\"id\"
            INNER JOIN public.\"Subjects\" AS t3 ON t1.\"Lesson_id\" = t3.\"id\"
            INNER JOIN public.\"Professors\" AS t4 ON t1.\"Professor_id\" = t4.\"id\"
            INNER JOIN public.\"Pairs\" AS t5 ON t1.\"Pair_id\" = t5.\"id\"
            INNER JOIN public.\"Classrooms\" AS t6 ON t1.\"Classroom_id\" = t6.\"id\"
            " . ($id != 0 ? "WHERE t2.\"id\" = $id" : " ") .
            "ORDER BY t1.\"Date\", \"Pair_time\"");
        while ($row = pg_fetch_row($result)) {
            $data[] = ['pair_time' => $row[0], 'date' => $row[1], 'classroom' => $row[2], 'lesson' => $row[3],
                'professor' => $row[4], 'group' => $row[5]];
        }
        return $data;
    }

    public function getScheduleDate(){
        $data = [];
        $result = pg_query($this->con, "SELECT DISTINCT(t1.\"Date\") FROM public.\"Schedule\" AS t1
            ORDER BY t1.\"Date\"");
        while ($row = pg_fetch_row($result)) {
            $data[] = ['date' => $row[0]];
        }
        return $data;
    }

    public function getAllTasks(){
        $data = [];
        $result = pg_query($this->con, "SELECT t1.\"id\", t2.\"Name\", t1.\"Text\" FROM public.\"Tasks\" AS t1
            INNER JOIN public.\"Subjects\" AS t2 ON t1.\"subject_id\" = t2.\"id\"");
        while ($row = pg_fetch_row($result)) {
            $data[] = ['id' => $row[0], 'name' => $row[1], 'text' => $row[2]];
        }
        return $data;
    }

    public function insertTask($subjectId, $text){
        $result = pg_query($this->con,"INSERT INTO public.\"Tasks\" (\"subject_id\", \"Text\")
            VALUES('$subjectId', '$text') RETURNING id");
        $result = pg_fetch_array($result);
        if($result){
            pg_query($this->con,"
        DO
        \$do\$
            DECLARE 
	            i bigint;
            BEGIN
	            FOR i IN (SELECT id FROM public.\"Students\") LOOP
		            INSERT INTO public.\"Marks\" (student_id, task_id, mark) VALUES(i, $result[id], null);
	            END LOOP;
            END
        \$do\$
        LANGUAGE plpgsql;");
            return constants::taskSuccessfullInsert;
        }
        else{
            constants::taskFailedInsert;
        }
    }

    public function getAllSubjects(){
        $data = [];
        $result = pg_query($this->con, "SELECT * FROM public.\"Subjects\"");
        while ($row = pg_fetch_row($result)) {
            $data[] = ['id' => $row[0], 'name' => $row[1]];
        }
        return $data;
    }

    public function getSubjectTasks($id){
        $data = [];
        $result = pg_query($this->con, "SELECT t1.id, t2.\"Name\", t1.\"Text\" FROM \"Tasks\" t1
            JOIN \"Subjects\" t2 ON t1.subject_id = t2.id
            WHERE t2.id = $id");
        while ($row = pg_fetch_row($result)) {
            $data[] = ['id' => $row[0], 'name' => $row[1], 'text' => $row[2]];
        }
        return $data;
    }

    public function getMarks($id){
        $data = [];
        $result = pg_query($this->con, "SELECT concat(t2.\"First_Name\", ' ', t2.\"Last_Name\", ' ', t2.\"Middle_Name\"),
            t1.\"mark\" FROM public.\"Marks\" AS t1
            INNER JOIN public.\"Students\" AS t2 ON t1.\"student_id\" = t2.id
            INNER JOIN public.\"Tasks\" AS t3 ON t1.\"task_id\" = t3.id
            INNER JOIN public.\"Subjects\" AS t4 ON t3.\"subject_id\" = t4.id
            WHERE t4.\"id\" = $id
            ORDER BY t2.id, t1.task_id");
        while ($row = pg_fetch_row($result)) {
            $data[] = ['name' => $row[0], 'mark' => $row[1]];
        }
        return $data;
    }

    public function login($username, $password){
        $password = md5($password);
       if(pg_num_rows(pg_query($this->con, "SELECT * FROM public.\"users\" WHERE username = '$username' 
                                 AND password = '$password'")) == 1){
           return true;
       }
       else{
           return false;
       }

    }
}