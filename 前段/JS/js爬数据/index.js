var page = require('webpage').create();
var fs = require('fs')

var url = 'http://db.duowan.com/lushi/card/list/eyJwIjoxLCJzb3J0IjoiaWQuZGVzYyJ9.html';

page.open(url, function(status) {
  
  var result = page.evaluate(function() {
  	var trs = document.querySelectorAll('.mod-table tbody tr');
	trs = [].slice.apply(trs);
	trs = trs.map(function(tr) {
	  
	  return {
	    name: tr.querySelector('.name a').innerHTML,
	    txt: tr.querySelector('.txt').innerHTML,
	    job: tr.querySelector('td:nth-child(4)').innerHTML,
	    type: tr.querySelector('td:nth-child(5)').innerHTML,
	    f: tr.querySelector('td:nth-child(6)').childNodes[0].textContent,
	    g: tr.querySelector('td:nth-child(7)').childNodes[0].textContent,
	    s: tr.querySelector('td:nth-child(8)').childNodes[0].textContent
	  }
	});
    return trs;
  });
  
  fs.write('result.json', JSON.stringify(result, null, 2), 'w')
  
  phantom.exit();
});

// phantomjs  --output-encoding=gb2312 --script-encoding=utf8 index.js