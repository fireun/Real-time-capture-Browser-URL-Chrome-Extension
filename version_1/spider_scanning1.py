# scanning.py

#!/usr/bin/env python
import time
#import requests  # Import the requests library
from zapv2 import ZAPv2

def process_urls(url):
    # The URL of the application to be tested
    target = url
    # Change to match the API key set in ZAP, or use None if the API key is disabled
    apiKey = 'ddueupb2fk04jfr4b22pc9n6qk'

    # By default ZAP API client will connect to port 8080
    ##zap = ZAPv2(apikey=apiKey)
    # Use the line below if ZAP is not listening on port 8080, for example, if listening on port 8090
    #zap = ZAPv2(apikey=apiKey, proxies={'http': 'http://127.0.0.1:8080', 'https': 'http://127.0.0.1:8080'})
    # Increase the number of retries
    zap = ZAPv2(apikey=apiKey, proxies={'http': 'http://127.0.0.1:8080', 'https': 'http://127.0.0.1:8080'})


    print('Spidering target {}'.format(target))
    # The scan returns a scan id to support concurrent scanning
    scanID = zap.spider.scan(target)
    while int(zap.spider.status(scanID)) < 100:
        # Poll the status until it completes
        print('Spider progress %: {}'.format(zap.spider.status(scanID)))
        time.sleep(1)

    print('Spider has completed!')
    # Prints the URLs the spider has crawled
    print('\n'.join(map(str, zap.spider.results(scanID))))
    #spider_results = '\n'.join(map(str, zap.spider.results(scanID)))

    # If required post-process the spider results
     # Send the results to a PHP script
    #send_results_to_php(spider_results)

    # TODO: Explore the Application more with Ajax Spider or Start scanning the application for vulnerabilities



