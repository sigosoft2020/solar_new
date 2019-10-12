<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Polls extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('M_upcomingpolls','polls');
			$this->load->model('M_completedpolls','pollsCompleted');
			$this->load->model('M_polls','poll');
			$this->load->model('Common');
		
	}
	public function upcoming()
	{
		$this->load->view('admin/polls/upcoming');
	}
	public function getUpcoming()
	{
		$result = $this->polls->make_datatables();
		$data = array();
		foreach ($result as $res) {

			// $options = $this->Common->get_details('poll_options',array('poll_id' => $res->poll_id))->result();
			// $string = '<p>';
			// $i = 1;
			// foreach ($options as $opt) {
			// 	$concat = $i . ' . ' . $opt->option_name . ' <br>';
			// 	$string = $string . $concat;
			// }
			$string = '';
			$i = 1;

			$total = $this->poll->getTotal($res->poll_id);
			$options = $this->poll->getOptions($res->poll_id);
			foreach ($options as $option) {
				$string = $string . '<span class="commnet-item-msg">' . $i . " . " . $option->option_name . '<span style="float:right;">';

				$opt_total = $this->poll->getTotalOfOption($option->opt_id);
				if ($total == 0) {
					$percent = 0;
				}
				else {
					$percent = ( $opt_total * 100 ) / $total;
					if(gettype($percent) == 'integer')
					{
						$percent = $percent;
					}
					else {
						$percent = number_format((float)$percent, 2, '.', '');
					}
				}
				$string = $string . $percent . ' %</span></span><br>';
				$i++;
			}

			$date = date('d/m/Y',strtotime($res->end_date));

			$sub_array = array();
			$sub_array[] = $res->question;
			$sub_array[] = $date;
			$sub_array[] = $res->end_time;
			$sub_array[] = $string;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/polls/edit/'.$res->poll_id) . '"><i class="fa fa-pencil-square-o"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->polls->get_all_data(),
			"recordsFiltered" => $this->polls->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function completed()
	{
		$this->load->view('admin/polls/completed');
	}

	public function getCompleted()
	{
		$result = $this->pollsCompleted->make_datatables();
		$data = array();
		foreach ($result as $res) {

			// $options = $this->Common->get_details('poll_options',array('poll_id' => $res->poll_id))->result();
			// $string = '<p>';
			// $i = 1;
			// foreach ($options as $opt) {
			// 	$concat = $i . ' . ' . $opt->option_name . ' <br>';
			// 	$string = $string . $concat;
			// }

			$string = '';
			$i = 1;

			$total = $this->poll->getTotal($res->poll_id);
			$options = $this->poll->getOptions($res->poll_id);
			foreach ($options as $option) {
				$string = $string . '<span class="commnet-item-msg">' . $i . " . " . $option->option_name . '<span style="float:right;">';

				$opt_total = $this->poll->getTotalOfOption($option->opt_id);
				if ($total == 0) {
					$percent = 0;
				}
				else {
					$percent = ( $opt_total * 100 ) / $total;
					if(gettype($percent) == 'integer')
					{
						$percent = $percent;
					}
					else {
						$percent = number_format((float)$percent, 2, '.', '');
					}
				}
				$string = $string . $percent . ' %</span></span><br>';
				$i++;
			}

			$date = date('d/m/Y',strtotime($res->end_date));

			$sub_array = array();
			$sub_array[] = $res->question;
			$sub_array[] = $date;
			$sub_array[] = $res->end_time;
			$sub_array[] = $string;

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->pollsCompleted->get_all_data(),
			"recordsFiltered" => $this->pollsCompleted->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}


	public function add()
	{
		$this->load->view('admin/polls/add');
	}

	public function addPoll()
	{
		$question = $this->security->xss_clean($this->input->post('question'));
		$end_date = $this->security->xss_clean($this->input->post('end_date'));
		$end_time = $this->security->xss_clean($this->input->post('end_time'));

		$options = $this->security->xss_clean($this->input->post('options'));

		$ts = $end_date . " " . date('H:i:s',strtotime($end_time));

		$array = [
			'question' => $question,
			'end_date' => $end_date,
			'end_time' => $end_time,
			'ts' => $ts,
			'status' => 1
		];

		if ($id = $this->Common->insert('polls',$array)) {
			foreach ($options as $opt) {
				$option = [
					'option_name' => $opt,
					'poll_id' => $id
				];
				$this->Common->insert('poll_options',$option);
			}

			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'New poll added..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add poll..!');
		}
		redirect('admin/polls/upcoming');
	}

	public function edit($poll_id)
	{
		$check = $this->Common->get_details('polls',array('poll_id' => $poll_id));
		if ($check->num_rows() > 0) {
			$data['poll'] = $check->row();
			$data['options'] = $this->Common->get_details('poll_options',array('poll_id' => $poll_id))->result();
			$this->load->view('admin/polls/edit',$data);
		}
		else {
			redirect('admin/polls/upcoming');
		}
	}

	public function deletePollOption()
	{
		$opt_id = $this->input->post('opt_id');
		$array = [
			'opt_id' => $opt_id
		];
		$this->Common->delete('results',$array);
		$this->Common->delete('poll_options',$array);

		echo '1';
	}

	public function editPoll()
	{
		$poll_id = $this->security->xss_clean($this->input->post('poll_id'));

		$question = $this->security->xss_clean($this->input->post('question'));
		$end_date = $this->security->xss_clean($this->input->post('end_date'));
		$end_time = $this->security->xss_clean($this->input->post('end_time'));
		$status = $this->security->xss_clean($this->input->post('status'));

		$options = $this->security->xss_clean($this->input->post('options'));

		$ts = $end_date . " " . date('H:i:s',strtotime($end_time));

		$array = [
			'question' => $question,
			'end_date' => $end_date,
			'end_time' => $end_time,
			'ts' => $ts,
			'status' => $status
		];

		if ($this->Common->update('poll_id',$poll_id,'polls',$array)) {
			$opts = $this->Common->get_details('poll_options',array('poll_id' => $poll_id))->result();
			foreach ($opts as $op) {
				$option = $this->security->xss_clean($this->input->post('options' . $op->opt_id));
				$array = [
					'option_name' => $option
				];
				$this->Common->update('opt_id',$op->opt_id,'poll_options',$array);
			}

			foreach ($options as $opt) {
				$option = [
					'option_name' => $opt,
					'poll_id' => $poll_id
				];
				$this->Common->insert('poll_options',$option);
			}

			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Poll details updated..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to update ..!');
		}
		redirect('admin/polls/upcoming');
	}
}
?>
