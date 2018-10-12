<?php
/**
 * Created by PhpStorm.
 * User: Himel
 * Date: 3/30/14
 * Time: 1:02 PM
 */


class pdfReport extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        require_once(APPPATH.'libraries/html2pdf/html2pdf.class.php');
        try
        {
            $this->load->model('mdomains');
            $view_type = $this->input->post('view_type');
            $report_option = $this->input->post('report_option');
            $domain = $this->mdomains->tbl_get(array('clientId'=>$this->input->post('client_id')));
            $this->load->model('mservices');
            $date_from = $this->input->post('dateFrom');
            $date_to = $this->input->post('dateTo');
            $response = array();
            $response['report_option'] = $report_option;
            $response['date_from'] = $date_from;
            $response['date_to'] = $date_to;



            switch($view_type)
            {
                case 'Custom':
                    $this->load->model('smsreport');
                    $clientId = $this->input->post('client_id');
                    $smsReport = new SmsReport();
                    if(!empty($clientId)){
                        switch($report_option)
                        {
                            case 'none':

                                $response['user_type'] = $this->authenticate->get_user_type();
                                $response['result'] = '';
                                break;

                            case 'today':

                                $response['user_type'] = $this->authenticate->get_user_type();
                                $response['result'] = $smsReport->getReportToday($clientId,'',true);
                                break;

                            case 'custom':
                                //                          echo $clientId;
                                $response['user_type'] = $this->authenticate->get_user_type();
                                $response['result'] = $smsReport->getReportBetweenDate($clientId, $date_from, $date_to,true);
                                break;

                            default:

                                $response['user_type'] = $this->authenticate->get_user_type();
                                $response['result'] = $smsReport->getReportByDuration($clientId, $report_option,true);
                                break;
                        }
                    }else{
                        $response['result'] = '<h4 style="color:tomato;">Client Not Selected.</h4>';
                    }
                    break;
                case 'Client':

                    $this->load->model('smsreport');
                    $clientId = $this->input->post('client_id');
                    $smsReport = new SmsReport();
                    if(!empty($clientId)){
                        switch($report_option)
                        {
                            case 'none':

                                $response['user_type'] = $this->authenticate->get_user_type();
                                $response['result'] = '';
                                break;

                            case 'today':

                                $response['user_type'] = $this->authenticate->get_user_type();
                                $response['result'] = $smsReport->getReportToday($clientId,'',true);
                                break;
                            case 'custom':
    //                          echo $clientId;
                                $response['user_type'] = $this->authenticate->get_user_type();
                                $response['result'] = $smsReport->getReportBetweenDate($clientId, $date_from, $date_to,true);
                                break;
                            default:

                                $response['user_type'] = $this->authenticate->get_user_type();
                                $response['result'] = $smsReport->getReportByDuration($clientId, $report_option,true);
                                break;
                        }
                    }else{
                        $response['result'] = '<h4 style="color:tomato;">Client Not Selected.</h4>';
                    }
                    break;
            }
            $html2pdf = new HTML2PDF('P', 'A4', 'fr');

            $html2pdf->setDefaultFont('Arial');
            $content = $this->load->view('report/vsms_report_summary_pdf',$response,true);
            $html2pdf->writeHTML($content);

            $html2pdf->Output($domain[0]['name'].'-'.date('Y-m-d',strtotime($date_from)).'-'.date('Y-m-d',strtotime($date_to)).'.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

} 