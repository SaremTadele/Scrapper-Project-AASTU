"use strict";
const puppeteer = require('puppeteer');
(async () => {
  var args = process.argv.slice(2);
  process.on('unhandledRejection', up => { throw up })
  var argarr = ['--no-sandbox', '--disable-setuid-sandbox'];
  if(args[1] !== undefined && args[1] !== 'null')
  {
      argarr.push("--proxy-server=" + args[1]);
  }
  if(args[2] != 'default')
  {
      argarr.push("--user-agent=" + args[2]);
  }
  if(args[3] != 'default')
  {
      var cookies = args[3].split(';').reduce((cookieObject, cookieString) => {
   		let splitCookie = cookieString.split('=')
   		try {
   		  cookieObject[splitCookie[0].trim()] = decodeURIComponent(splitCookie[1])
   		} catch (error) {
   			cookieObject[splitCookie[0].trim()] = splitCookie[1]
   		}
   		return cookieObject
   	  }, []);
      await page.setCookie(cookies);
  }
  if(args[4] != 'default')
  {
      var xres = args[4].split(":");
      if(xres[1] != undefined)
      {
          var user = xres[0];
          var pass = xres[1];
          const auth = new Buffer(`${user}:${pass}`).toString('base64');
          await page.setExtraHTTPHeaders({
              'Authorization': `Basic ${auth}`                    
          });
      }
  }
  const browser = await puppeteer.launch({args: argarr});
  const page = await browser.newPage();
  await page.goto(args[0], {waitUntil: 'networkidle2'});
  let bodyHTML = await page.evaluate(() => document.body.innerHTML);
  console.log(bodyHTML);
  await browser.close();
})();