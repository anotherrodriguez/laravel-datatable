<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class patientCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $patient;

    public function __construct($patient)
    {
        //
        $this->patient = $patient;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $first_name = $this->patient->first_name;
        $last_name = $this->patient->last_name;
        $date_of_service = $this->patient->date_of_service;
        $site = $this->patient->status->department->site->name;
        $department = $this->patient->status->department->name;
        $emails = $this->patient->email()->get();
        $phone_numbers = $this->patient->phoneNumber()->get();
        $status = $this->patient->status->name;

        $mailMessage = new MailMessage;
        $mailMessage->subject('New Patient Sign Up');
        $mailMessage->line('Patient Name: '.$this->patient->first_name.' '.$this->patient->last_name.'.');
        $mailMessage->line('Date of Service: '.$date_of_service.'.');
        $mailMessage->line('Site: '.$site.'.');
        $mailMessage->line('Department: '.$department.'.');
        
        foreach ($emails as $key => $email) {
            # code...
            $num = $key+1; 
            $mailMessage->line("Email $num: ".$email->email.'.');
            
        }

        foreach ($phone_numbers as $key => $phone_number) {
            # code...
        $num = $key+1;     
        $mailMessage->line("Phone Number $num: ".$phone_number->phone_number.'.');
        }

        $mailMessage->line('Status: '.$status.'.');
        $mailMessage->line('Thank you for using our application!');

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
