<?php
declare(strict_types=1);
// Isolate the static Contao boundary; exercise real Symfony Request/RequestStack.
namespace Contao {
    final class System {
        public static object $container;
        public static function getContainer(): object { return self::$container; }
    }
    class FrontendTemplate {}
}
namespace {
    if(count($argv)<2)throw new \InvalidArgumentException('Pass a Contao project vendor/autoload.php.');
    require $argv[1];
    require $argv[2]??__DIR__.'/../src/EventListener/ParseFrontendTemplateListener.php';
    $container=new \Symfony\Component\DependencyInjection\Container();
    $stack=new \Symfony\Component\HttpFoundation\RequestStack();
    $scope=new class {
        public array $seen=[];
        public function isBackendRequest(\Symfony\Component\HttpFoundation\Request $request):bool {
            $this->seen[]=$request;
            return $request->attributes->get('_scope')==='backend';
        }
    };
    $parser=new class {
        public int $calls=0;
        public function replace(string $buffer):string { ++$this->calls; return str_replace('{{demo}}','resolved',$buffer); }
    };
    $container->set('request_stack',$stack);
    $container->set('contao.routing.scope_matcher',$scope);
    $container->set('contao.insert_tag.parser',$parser);
    \Contao\System::$container=$container;
    $listener=new \Magmell\Contao\Inserttags\EventListener\ParseFrontendTemplateListener();
    $template=new \Contao\FrontendTemplate();
    $checks=0;
    $check=static function(bool $ok)use(&$checks):void { if(!$ok)throw new \RuntimeException('Template request regression'); ++$checks; };
    $check($listener('{{demo}}','mail_default',$template)==='{{demo}}');
    $check($scope->seen[0] instanceof \Symfony\Component\HttpFoundation\Request);
    $check($stack->getCurrentRequest()===null&&$parser->calls===0);
    $request=\Symfony\Component\HttpFoundation\Request::create('/frontend');
    $stack->push($request);
    $check($listener('{{demo}}','mail_default',$template)==='{{demo}}');
    $check(end($scope->seen)===$request&&$stack->getCurrentRequest()===$request);
    $request->attributes->set('_scope','backend');
    $GLOBALS['objPage']=new \stdClass();
    $check($listener('{{demo}}','ce_html',$template)==='{{demo}}');
    $check($parser->calls===0);
    $check($listener('{{demo}}','be_article',$template)==='resolved');
    $check($parser->calls===1&&end($scope->seen)===$request);
    echo json_encode(['cases'=>4,'checks'=>$checks,'no_request_fallback'=>'real Symfony Request','mail_or_provider_calls'=>0],JSON_THROW_ON_ERROR)."\n";
}
