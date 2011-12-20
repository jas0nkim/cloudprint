<?php

class GCPhandler {
    private $db;
    private $gcp_printers_db    = 'gcp_printers';   // database table name for GCP printer's information 
    private $printers_db        = 'printers';       // database table name for general printer's information

    private $gcp;

    /**
     * construct
     *
     * @param null $gcp_options
     * @internal param null $options
     */
    public function __construct($gcp_options=null) {
        $this->db = DB();

        $default_gcp_options = array(
             'company_name' => '',
             'email' => '',
             'password' => '',
         );

         if ($gcp_options) {
             $gcp_options = array_replace_recursive($default_gcp_options, $gcp_options);
         } else {
             $gcp_options = $default_gcp_options;
         }

         try {
             $this->gcp = new GoogleCloudPrint($gcp_options);
         } catch (Exception $e) {
             echo "Error: " . $e;
         }
    }

    /**
     * destruct
     */
    public function __destruct() {
        if (isset($this->db)) {
            $this->db->close();
        }
    }

    public function create_printer() {
        // search printers
        $info = json_decode($this->gcp->search());

        // create a new row if it is a new info, otherwise update an existing row.
        if ($info->success) {
            $this->show_message("[Message] All printers have been searched");

            foreach ($info->printers as $printer) {
                if ($printer->id == '__google__docs') {
                    continue;
                }

                // get GCP printer info
                $printer_info = json_decode($this->gcp->printer($printer->id));
                if ($printer_info->success) {
                    $this->show_message("[Message] Printer ".$printer->id." information has been retrieved");

                    $gcp_printer = $printer_info->printers[0];
                    $gcp_printer_model = new GCP_Printer_Model($this->db);
                    $gcp_printer_model->printerid = $gcp_printer->id;
                    $gcp_printer_model->printer_id = 0;
                    $gcp_printer_model->name = $gcp_printer->name;
                    $gcp_printer_model->display_name = $gcp_printer->displayName;
                    $gcp_printer_model->type = $gcp_printer->type;
                    $gcp_printer_model->proxy = $gcp_printer->proxy;
                    $gcp_printer_model->status = $gcp_printer->status;
                    $gcp_printer_model->caps_hash = $gcp_printer->capsHash;
                    $gcp_printer_model->create_time = $gcp_printer->createTime;
                    $gcp_printer_model->update_time = $gcp_printer->updateTime;
                    $gcp_printer_model->access_time = $gcp_printer->accessTime;
                    $gcp_printer_model->number_of_documents = $gcp_printer->numberOfDocuments;
                    $gcp_printer_model->number_of_pages = $gcp_printer->numberOfPages;
                    $gcp_printer_model->caps_format = $gcp_printer->capsFormat;
                    $gcp_printer_model->tags = json_encode($gcp_printer->tags);
                    $gcp_printer_model->capabilities = json_encode($gcp_printer->capabilities);
                    $gcp_printer_model->access = json_encode($gcp_printer->access);

                    if ($gcp_printer_model->insert_entry()) {
                        $this->show_message("[Message] Printer ".$printer->id." information has been inserted into database successfully");
                    } else {
                        $this->show_message("[Error] Printer ".$printer->id." information has not been inserted into database");
                    }
                }
            }
        } else {
            $this->show_message("[Error] ".$info->message);
        }
    }

    private function show_message($message) {
        echo $message."\n";
    }

}
