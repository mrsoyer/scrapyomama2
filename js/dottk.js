/*==============================================================================*/
/* Casper generated Wed Apr 27 2016 16:30:23 GMT+0200 (CEST) */
/*==============================================================================*/
//var casper2 = require('casper').create();
var x = require('casper').selectXPath;

//casper = require('casper').create();
casper.options.viewportSize = {width: 1412, height: 901};
casper.options.waitTimeout = 100000;
casper.echo("Casper CLI passed args:");
require("utils").dump(casper.cli.args);
var fs = require('fs');
casper.echo("Casper CLI passed options:");
require("utils").dump(casper.cli.options);

casper.on('page.error', function(msg, trace) {
   this.echo('Error: ' + msg, 'ERROR');
   for(var i=0; i<trace.length; i++) {
       var step = trace[i];
       this.echo('   ' + step.file + ' (line ' + step.line + ')', 'ERROR');
   }
});

var dom = casper.cli.get('foo');

function getAwesomeResponse(){
    casper.then(function() {
    casper.page = casper.newPage();
    casper.open('http://www.scrapyomama.xyz/Decaptcher/index/'+dom).then( function() {
         f = this.getHTML('body')
				this.echo("Captcha:"+f);
				return f;
	    });
	});
	return f;
}


casper.test.begin('Resurrectio test', function(test) {
   casper.start('http://www.dot.tk/fr/index.html?lang=fr');
   casper.waitForSelector("input[name='domainname']",
       function success() {
           this.sendKeys("input[name='domainname']", dom);
           casper.wait(3000);
       },
       function fail() {
           test.assertExists("input[name='domainname']");
   });
   casper.waitForSelector("form .buttonGrey3.left3",
       function success() {
           test.assertExists("form .buttonGrey3.left3");
           this.click("form .buttonGrey3.left3");
           casper.wait(10000);
       },
       function fail() {
           test.assertExists("form .buttonGrey3.left3");
   });
   /* submit form */
   casper.waitForSelector("input[name='forward_url']",
       function success() {
           test.assertExists("input[name='forward_url']");
           this.click("input[name='forward_url']");
       },
       function fail() {
           test.assertExists("input[name='forward_url']");
   });
   casper.waitForSelector("input[name='forward_url']",
       function success() {
           this.sendKeys("input[name='forward_url']", "gobadou.fr");
           casper.wait(3000);
       },
       function fail() {
           test.assertExists("input[name='forward_url']");
   });
   casper.waitForSelector("#captcha img",
       function success() {
           test.assertExists("#captcha img");
           this.captureSelector('../captcha/'+dom+'.png', '#captcha img');
       },
       function fail() {
           test.assertExists("#captcha img");
   });
   
   
   
 /*  casper.waitForPopup('http://www.scrapyomama.xyz/Decaptcher/index/'+dom, function() {
				//fetchText
				f = this.getHTML('body')
				this.echo("Captcha:"+f);
			   
	});*/
	
	
	
	
	casper.then(function(){
	
	
	    var myvar='http://www.scrapyomama.xyz/Decaptcher/index/'+dom;
	    data = this.evaluate(function(myvar) {
	        try {
	            return __utils__.sendAJAX(myvar, 'GET', null, false);
	        } catch (e) {
	            console.log("Error in fetching json object");
	        }
	    }, {
	        myvar : myvar
	    });
    
	});   
	    
	
	
	casper.waitForSelector("input[name='captcha']",
       function success() {
       		
			 var myvar='http://www.scrapyomama.xyz/Decaptcher/index/'+dom;
		    data = this.evaluate(function(myvar) {
		        try {
		            //return __utils__.sendAJAX(myvar, 'GET', null, false);
		            this.echo("Captcha2:"+__utils__.sendAJAX(myvar, 'GET', null, false));
		        } catch (e) {
		            console.log("Error in fetching json object");
		        }
		    }, {
		        myvar : myvar
		    });
		   
       		
       		this.echo("Captcha2:"+data);
            casper.sendKeys("input[name='captcha']", data);
       },
       function fail() {
           test.assertExists("input[name='captcha']");
   });
	
   casper.waitForSelector(x("//a[normalize-space(text())='Continue without Sign Up']"),
       function success() {
           this.click(x("//a[normalize-space(text())='Continue without Sign Up']"));
       },
       function fail() {
           test.assertExists(x("//a[normalize-space(text())='Continue without Sign Up']"));
   });
   casper.waitForSelector(x("//textarea[@name='share_comment' and @value='Just registered http://"+dom+".tk']"),
       function success() {
           test.assertExists(x("//textarea[@name='share_comment' and @value='Just registered http://"+dom+".tk']"));
         },
       function fail() {
           test.assertExists(x("//textarea[@name='share_comment' and @value='Just registered http://"+dom+".tk']"));
   });

   casper.run(function() {test.done();});
});

