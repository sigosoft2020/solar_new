<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Polls extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('M_polls','polls');
			$this->load->model('Common');
	}
	public function upcoming()
	{   
	    $id         = $this->security->xss_clean($this->input->post('user_id'));
	    $poll_check = $this->polls->upcoming();  
	    if($poll_check->num_rows()>0)
	    {
			$polls = $poll_check->result();
			foreach ($polls as $poll) {
				$poll->polled_option = $this->polls->checkPoll($id,$poll->poll_id);
				$poll->options = $this->polls->getOptions($poll->poll_id);
			}
			$return = [
                       'status'   => true,
                       'message'  => 'success',
                       'data'     => $polls
                   ];
		}
		else {
			$return = [
                       'status'   => false,
                       'message'  => 'failed',
                       'data'     => ''
                   ];
		}

		print_r(json_encode($return));
	}
	public function completed()
	{
		$completed_check =$this->polls->completed();
		if($completed_check->num_rows()>0)
		{
			$polls = $completed_check->result();
			foreach ($polls as $poll) {
				$total = $this->polls->getTotal($poll->poll_id);
				$options = $this->polls->getOptions($poll->poll_id);
				foreach ($options as $option) {
					$opt_total = $this->polls->getTotalOfOption($option->opt_id);
					if ($total == 0) {
						$option->percent = 0;
					}
					else {
						$percent = ( $opt_total * 100 ) / $total;
						if(gettype($percent) == 'integer')
						{
							$option->percent = $percent;
						}
						else {
							$option->percent = number_format((float)$percent, 2, '.', '');
						}
					}
				}
				$poll->options = $options;
			}
			$return = [
                       'status'   => true,
                       'message'  => 'success',
                       'data'     => $polls
                     ];
	  }
		else {
			$return = [
                       'status'   => false,
                       'message'  => 'failed',
                       'data'     => ''
                     ];
		}
		print_r(json_encode($return));
	}

	public function addPoll()
	{
	        $id      = $this->security->xss_clean($this->input->post('user_id'));
			$opt_id  = $this->security->xss_clean($this->input->post('opt_id'));
			$poll_id = $this->security->xss_clean($this->input->post('poll_id'));

			$array = [
				'opt_id' => $opt_id,
				'poll_id' => $poll_id,
				'member_id' => $id
			];

			if ($this->Common->insert('results',$array)) {
				$return = [
					'status' => true,
					'message' => 'Your poll has been added..!',
					'data' => ''
				];
			}
			else {
				$return = [
					'status' => false,
					'message' => 'Failed to add poll..!',
					'data' => ''
				];
			}

		print_r(json_encode($return));
	}

}
?>
