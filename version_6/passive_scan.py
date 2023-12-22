#!/usr/bin/env python
import time
from pprint import pprint
from zapv2 import ZAPv2


def passive_scan(url):

    apiKey = 'ddueupb2fk04jfr4b22pc9n6qk'
    #target = 'https://public-firing-range.appspot.com'
    target = url
    zap = ZAPv2(apikey=apiKey, proxies={'http': 'http://127.0.0.1:8080', 'https': 'http://127.0.0.1:8080'})

    # TODO : explore the app (Spider, etc) before using the Passive Scan API, Refer the explore section for details
    while int(zap.pscan.records_to_scan) > 0:
        # Loop until the passive scan has finished
        print('Records to passive scan : ' + zap.pscan.records_to_scan)
        time.sleep(2)

    print('Passive Scan completed')

     # Capture Passive scan results/alerts
    hosts = ', '.join(zap.core.hosts)
    alerts = zap.core.alerts()

    # Print Passive scan results/alerts
    ##print('Hosts: {}'.format(', '.join(zap.core.hosts)))
    ##print('Alerts: ')
    ##pprint(zap.core.alerts())

    
    # Return the results as a tuple
    return hosts, alerts