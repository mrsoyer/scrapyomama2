var casper1 = require('casper').create();
var casper2done = false;

casper1.start("http://www.dot.tk/fr/index.html?lang=fr").then(function(){
   
    
   
    casper1.waitForSelector("input[name='domainname']",
       function success() {
           casper1.sendKeys("input[name='domainname']", "fdsgfdsgdsgsdgsg");
      casper1.wait(10000);
   
    casper1.click("form .buttonGrey3.left3");
           casper!.wait(10000);
    casper1.capture("casper1_1.png");
     this.echo("DONE 2");
       },
       function fail() {
           test.assertExists("input[name='domainname']");
   });
   
   casper1.waitForSelector("form .buttonGrey3.left3",
       function success() {
           test.assertExists("form .buttonGrey3.left3");
           this.click("form .buttonGrey3.left3");
           casper.wait(10000);
       },
       function fail() {
           test.assertExists("form .buttonGrey3.left3");
   });
   
   
    var casper2 = require('casper').create();
    casper2.start("http://stackoverflow.com/contact").then(function(){
        casper1.echo(casper2.getCurrentUrl(), casper2.getTitle());
        casper2.capture("casper2.png");
    }).run(function(){
        this.echo("DONE 2");
        casper2done = true;
    });
}).waitFor(function check(){
    return casper2done;
}).then(function(){
    casper1.echo(casper1.getCurrentUrl(), casper1.getTitle()); // Comment to fix answer (min 6 chars)
    casper1.capture("casper1_2.png");
}).run(function(){
    this.echo("DONE");
    this.exit();
});