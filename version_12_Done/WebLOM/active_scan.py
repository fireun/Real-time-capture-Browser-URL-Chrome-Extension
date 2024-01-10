#!/usr/bin/env python
import time
from pprint import pprint
from zapv2 import ZAPv2


def active_scan(url):

    apiKey = 'ddueupb2fk04jfr4b22pc9n6qk'
    #target = 'https://public-firing-range.appspot.com'
    target = url
    zap = ZAPv2(apikey=apiKey, proxies={'http': 'http://127.0.0.1:8080', 'https': 'http://127.0.0.1:8080'})

    # TODO: explore the app (Spider, etc) before using the Active Scan API, Refer the explore section
    print('Active Scanning target {}'.format(target))
    scanID = zap.ascan.scan(target)


    while True:
        scan_status = zap.ascan.status(scanID)
        
        if scan_status == '100':
            # The scan is completed
            break
        elif scan_status == 'does_not_exist':
            print('Scan does not exist. Exiting.')
            break
        else:
            print('Scan progress %: {}'.format(scan_status))
        
        time.sleep(5)

        print('Active Scan completed')

        # Capture Passive scan results/alerts
        hosts = ', '.join(zap.core.hosts)
        alerts = zap.core.alerts()
        
        # Print vulnerabilities found by the scanning
        ##print('Hosts: {}'.format(', '.join(zap.core.hosts)))
        ##print('Alerts: ')
        ##pprint(zap.core.alerts(baseurl=target))
        ##print("ScarnID: ", scanID)

        return hosts, alerts