<?

defined('C5_EXECUTE') or die("Access Denied.");
class ConcreteUpgradeVersion562Helper {

	
	public $dbRefreshTables = array(
		'Queues',
		'QueueMessages',
		'QueuePageDuplicationRelations',
		'JobSets',
		'JobSetJobs'
	);

	public function run() {
		$j = Job::getByHandle('index_search_all');
		if (!is_object($j)) {
			Job::installByHandle('index_search_all');
		}

		$js = JobSet::getByName('Default');
		if (!is_object($js)) {
			$js = JobSet::add('Default');
		}
		$js->clearJobs();
		$jobs = Job::getList();
		foreach($jobs as $j) {
			if (!$js->supportsQueue()) {
				$j->addJob($j);	
			}
		}
	}


}