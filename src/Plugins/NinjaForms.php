<?php
/**
 * Ninja Forms Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Junaidbhura\Composer\WPProPlugins\Http;
use InvalidArgumentException;

/**
 * NinjaForms class.
 */
class NinjaForms extends AbstractEddPlugin {

	/**
	 * Get the download URL for this plugin from its API.
	 *
	 * @throws InvalidArgumentException If the package is unsupported.
	 * @return string
	 */
	protected function getDownloadUrlFromApi() {
		$name    = '';
		$env     = null;
		/**
		 * Membership licensing.
		 */
		$license = ( getenv( 'NINJA_FORMS_KEY' ) ?: null );
		$url     = ( getenv( 'NINJA_FORMS_URL' ) ?: null );

		/**
		 * List of official add-ons as of 2023-01-20.
		 *
		 * Packages are named according to their extension page slug or brand name
		 * rather than their WordPress plugin directory name which often is misspelled
		 * or changes between versions of Ninja Forms.
		 *
		 * If the installed package must match it's official plugin basename,
		 * use composer/installers {@link https://github.com/composer/installers#custom-install-names custom install name}
		 * `installer-name`.
		 */
		switch ( $this->slug ) {
			case 'ninja-forms-activecampaign':
				// NF plugin basename: ninja-forms-active-campaign
				$name = 'ActiveCampaign';
				$env  = 'ACTIVECAMPAIGN';
				break;

			case 'ninja-forms-advanced-datepicker':
				// NF plugin basename: ninja-forms-advanced-datepicker
				$name = 'Advanced Datepicker';
				$env  = 'ADVANCED_DATEPICKER';
				break;

			case 'ninja-forms-authorize-net':
				// NF plugin basename: ninja-forms-authorize-net
				$name = 'Authorize.net';
				$env  = 'AUTHORIZE_NET';
				break;

			case 'ninja-forms-aweber':
				// NF plugin basename: ninja-forms-aweber
				$name = 'AWeber';
				$env  = 'AWEBER';
				break;

			case 'ninja-forms-campaign-monitor':
				// NF plugin basename: ninja-forms-campaign-monitor
				$name = 'Campaign Monitor';
				$env  = 'CAMPAIGN_MONITOR';
				break;

			case 'ninja-forms-capsule-crm':
				// NF plugin basename: ninja-forms-capsule-crm
				$name = 'Capsule CRM';
				$env  = 'CAPSULE_CRM';
				break;

			case 'ninja-forms-civicrm':
				// NF plugin basename: ninja-forms-civicrm
				$name = 'CiviCRM';
				$env  = 'CIVICRM';
				break;

			case 'ninja-forms-cleverreach':
				// NF plugin basename: ninja-forms-cleverreach
				$name = 'CleverReach';
				$env  = 'CLEVERREACH';
				break;

			case 'ninja-forms-clicksend':
				// NF plugin basename: ninja-forms-clicksend
				$name = 'ClickSend SMS';
				$env  = 'CLICKSEND';
				break;

			case 'ninja-forms-conditional-logic':
				// NF plugin basename: ninja-forms-conditionals, ninja-forms-conditional-logic
				$name = 'Conditional Logic';
				$env  = 'CONDITIONAL_LOGIC';
				break;

			case 'ninja-forms-constant-contact':
				// NF plugin basename: ninja-forms-constant-contact
				$name = 'Constant Contact';
				$env  = 'CONSTANT_CONTACT';
				break;

			case 'ninja-forms-convertkit':
				// NF plugin basename: ninja-forms-convertkit
				$name = 'ConvertKit';
				$env  = 'CONVERTKIT';
				break;

			case 'ninja-forms-elavon':
				// NF plugin basename: ninja-forms-elavon-payment-gateway
				$name = 'Elavon';
				$env  = 'ELAVON';
				break;

			case 'ninja-forms-emailoctopus':
				// NF plugin basename: ninja-forms-emailoctopus
				$name = 'EmailOctopus';
				$env  = 'EMAILOCTOPUS';
				break;

			case 'ninja-forms-emma':
				// NF plugin basename: ninja-forms-emma
				$name = 'Emma';
				$env  = 'EMMA';
				break;

			case 'ninja-forms-excel-export':
				// NF plugin basename: ninja-forms-excel-export
				$name = 'Excel Export';
				$env  = 'EXCEL_EXPORT';
				break;

			case 'ninja-forms-help-scout':
				// NF plugin basename: ninja-forms-helpscout
				$name = 'Help Scout';
				$env  = 'HELP_SCOUT';
				break;

			case 'ninja-forms-hubspot':
				// NF plugin basename: ninja-forms-hubspot
				$name = 'HubSpot';
				$env  = 'HUBSPOT';
				break;

			case 'ninja-forms-insightly':
				// NF plugin basename: ninja-forms-insightly-crm
				$name = 'Insightly CRM';
				$env  = 'INSIGHTLY';
				break;

			case 'ninja-forms-layout-styles':
				// NF plugin basename: ninja-forms-style, ninja-forms-layout-styles
				$name = 'Layout and Styles';
				$env  = 'LAYOUT_STYLES';
				break;

			case 'ninja-forms-mailchimp':
				// NF plugin basename: ninja-forms-mail-chimp, ninja-forms-mailchimp
				$name = 'Mailchimp';
				$env  = 'MAILCHIMP';
				break;

			case 'ninja-forms-mailpoet':
				// NF plugin basename: ninja-forms-mailpoet
				// Formerly Wysija
				$name = 'MailPoet';
				$env  = 'MAILPOET';
				break;

			case 'ninja-forms-multi-step':
				// NF plugin basename: ninja-forms-multi-part
				$name = 'Multi Step Forms';
				$env  = 'MULTI_STEP';
				break;

			case 'ninja-forms-onepagecrm':
				// NF plugin basename: ninja-forms-onepage-crm, ninja-forms-onepagecrm
				$name = 'OnePageCRM';
				$env  = 'ONEPAGECRM';
				break;

			case 'ninja-forms-paypal-express':
				// NF plugin basename: ninja-forms-paypal-express
				$name = 'PayPal Express';
				$env  = 'PAYPAL_EXPRESS';
				break;

			case 'ninja-forms-pdf-submissions':
				// NF plugin basename: ninja-forms-pdf-submissions
				$name = 'PDF Form Submission';
				$env  = 'PDF_SUBMISSIONS';
				break;

			case 'ninja-forms-pipeline-crm':
				// NF plugin basename: ninja-forms-pipeline-deals-crm
				// Formerly PipelineDeals
				$name = 'Pipeline CRM';
				$env  = 'PIPELINE_CRM';
				break;

			case 'ninja-forms-post-creation':
				// NF plugin basename: ninja-forms-post-creation
				$name = 'Front-End Posting';
				$env  = 'POST_CREATION';
				break;

			case 'ninja-forms-recurly':
				// NF plugin basename: ninja-forms-recurly
				$name = 'Recurly';
				$env  = 'RECURLY';
				break;

			case 'ninja-forms-salesforce':
				// NF plugin basename: ninja-forms-salesforce-crm
				$name = 'Salesforce CRM';
				$env  = 'SALESFORCE';
				break;

			case 'ninja-forms-save-progress':
				// NF plugin basename: ninja-forms-save-progress
				$name = 'Save Progress';
				$env  = 'SAVE_PROGRESS';
				break;

			case 'ninja-forms-scheduled-exports':
				// NF plugin basename: ninja-forms-scheduled-exports
				$name = 'Scheduled Submissions Export';
				$env  = 'SCHEDULED_EXPORTS';
				break;

			case 'ninja-forms-slack':
				// NF plugin basename: ninja-forms-slack
				$name = 'Slack';
				$env  = 'SLACK';
				break;

			case 'ninja-forms-stripe':
				// NF plugin basename: ninja-forms-stripe
				$name = 'Stripe';
				$env  = 'STRIPE';
				break;

			case 'ninja-forms-trello':
				// NF plugin basename: ninja-forms-trello
				$name = 'Trello';
				$env  = 'TRELLO';
				break;

			case 'ninja-forms-twilio':
				// NF plugin basename: ninja-forms-twilio
				$name = 'Twilio SMS';
				$env  = 'TWILIO';
				break;

			case 'ninja-forms-uploads':
				// NF plugin basename: ninja-forms-uploads
				$name = 'File Uploads';
				$env  = 'UPLOADS';
				break;

			case 'ninja-forms-user-analytics':
				// NF plugin basename: ninja-forms-user-analytics
				$name = 'User Analytics';
				$env  = 'USER_ANALYTICS';
				break;

			case 'ninja-forms-user-management':
				// NF plugin basename: ninja-forms-user-management
				$name = 'User Management';
				$env  = 'USER_MANAGEMENT';
				break;

			case 'ninja-forms-webhooks':
				// NF plugin basename: ninja-forms-webhooks
				$name = 'Webhooks';
				$env  = 'WEBHOOKS';
				break;

			case 'ninja-forms-zapier':
				// NF plugin basename: ninja-forms-zapier
				$name = 'Zapier';
				$env  = 'ZAPIER';
				break;

			case 'ninja-forms-zoho':
				// NF plugin basename: ninja-forms-zoho-crm
				$name = 'Zoho CRM';
				$env  = 'ZOHO';
				break;

			default:
				throw new InvalidArgumentException( sprintf(
					'Could not find a matching package for %s. Check the package spelling and that the package is supported',
					$this->getPackageName()
				) );
		}

		if ( $env ) {
			/**
			 * Use add-on licensing if available, otherwise use membership licensing.
			 */
			$license = ( getenv( "NINJA_FORMS_{$env}_KEY" ) ?: $license );
			$url     = ( getenv( "NINJA_FORMS_{$env}_URL" ) ?: $url );
		}

		$http = new Http();

		$api_query = array(
			'edd_action' => 'get_version',
			'license'    => $license,
			'item_name'  => $name,
			'url'        => $url,
		);

		// If no version is specified, we are fetching the latest version.
		if ( $this->version ) {
			$api_query['version'] = $this->version;
		}

		$api_url = 'https://ninjaforms.com';

		return $http->get( $api_url, $api_query );
	}

}
