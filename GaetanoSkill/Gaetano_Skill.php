<?php
/**
 * Created by PhpStorm.
 * User: dariocastellano
 * Date: 15/01/2019
 * Time: 11:35
 */

require_once dirname( __DIR__ ) . '/vendor/awsmug/alexa-php-sdk/src/alexa-sdk.php';

use Alexa\Skill_Template;
use Alexa\Exception;

class Gaetano_Skill extends Skill_Template {
    public function interact()
    {
        switch( $this->input()->request()->get_type() ) {
			case 'LaunchRequest':
				$response = $this->launch_request();
				break;
			case 'IntentRequest':
				$response = $this->intent_request();
				break;
			case 'SessionEndedRequest':
				$response = $this->end_request();
				break;
			default:
				$response = $this->failed_request();
				break;
		}

		return $response;
    }


    protected function launch_request()
    {
        $this->output()->response()->output_speech()->set_text( 'Uè uagliò, tutt a ppòst?' );
        return $this->output()->response()->get();
    }

    protected function end_request()
    {
        $this->output()->response()->output_speech()->set_text( 'Statt bbuòn' );
        $this->output()->response()->end_session();
        return $this->output()->response()->get();
    }

    protected function failed_request()
    {
        $this->output()->response()->output_speech()->set_text( 'è succieso nu problèm' );
        return $this->output()->response()->get();
    }


    public function intent_request() {
        if ('DiDoveSeiIntent' === $this->input()->request()->intent()->get_name()) {
            if($this->input()->request()->intent()->get_slot_value("dove") === 'dove') {
                $this->whereFrom();
            }
            else {
                $this->defautlIntent();
            }
        }

        if ('NomeIntent' === $this->input()->request()->intent()->get_name()) {
            if($this->input()->request()->intent()->get_slot_value("come") === 'come') {
                $this->noemi();
            }
            else {
                $this->defautlIntent();
            }
        }

        if ('AMAZON.StopIntent' === $this->input()->request()->intent()->get_name()) {
            $this->end_request();
        }

        return $this->output()->get_json();
    }

    protected function whereFrom()
    {
        $this->output()->response()->output_speech()->set_text( 'Song \'e \'Napule' );
        return;
    }

    protected function noemi()
    {
        $this->output()->response()->output_speech()->set_text( 'Scommett ca t chiamm Noemi' );
        return;
    }

    protected function defautlIntent()
    {
        $this->output()->response()->output_speech()->set_text( 'che stai rìcienn?' );
        return;
    }
}

$gaetano_Skill = new Gaetano_Skill( 'amzn1.ask.skill.5f0730ee-23f9-442d-b7e3-16d36e97849e' );

try{
    $gaetano_Skill->run();
} catch( Exception $exception) {
    $gaetano_Skill->log( $exception->getMessage() );
    echo $exception->getMessage();
}
