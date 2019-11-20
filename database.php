<?php
    class db_handler
    {
        public $db_connection;

        function __construct()
        {
            $this->db_connection = pg_connect("host=localhost port=5432 dbname=KP25 user=postgres password=root")
            or die("Error!" . pg_errormessage($this->db_connection));
        }

        public function getAllEmployees()
        {
            $data = [];
            $result = pg_query($this->db_connection, "SELECT * FROM public.phonebook_person");
            while ($row = pg_fetch_row($result)) {
                $data[] = ['name' => $row[1], 'email' => $row[2]];
            }
            return $data;
        }
    }
?>