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
            t2.\"Name\" FROM public.\"Students\" AS t1 INNER JOIN public.\"Groups\" AS t2 ON t1.\"Group_id\"= t2.Id");
        while ($row = pg_fetch_row($result)) {
            $data[] = ['name' => $row[0], 'group' => $row[1], ];
        }
        return $data;
    }

    public function getAllGroups(){
        $data = [];
        $result = pg_query($this->con, "SELECT * FROM public.\"Groups\"");
        while ($row = pg_fetch_row($result)) {
            $data[] = ['id' => $row[0] ,'name' => $row[1]];
        }
        return $data;
    }

    public function getStudentsByGroup($id){
        $data = [];
        $result = pg_query($this->con, "SELECT concat(t1.\"First_Name\", ' ', t1.\"Last_Name\", ' ', t1.\"Middle_Name\"), 
            t2.\"Name\" FROM public.\"Students\" AS t1 INNER JOIN public.\"Groups\" AS t2 ON t1.\"Group_id\"= t2.Id
            WHERE t1.\"Group_id\" = '$id'");
        while ($row = pg_fetch_row($result)) {
            $data[] = ['name' => $row[0], 'group' => $row[1]];
        }
        return $data;
    }

}