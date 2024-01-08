from flask import Flask, request, jsonify
from spider_scanning1 import spider_scan #get the function from scannning.py file
from passive_scan import passive_scan
from active_scan import active_scan
from pprint import pprint #make print function more beutiful
import logging
import requests  # Import the requests library
from urllib.parse import urlparse #get domain name

app = Flask(__name__)


# Configure logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

@app.route('/GetURL3', methods=['POST'])
def handle_data():
    data = request.get_json()

    # Access the URLs
    urls = data.get('urls', [])

    # Patterns to skip
    skip_patterns = [
        'chrome://new-tab-page/',
        'about:blank',
        'https://www.google.com/search?q=',
        'https://www.youtube.com/',
        'https://www.facebook.com/',
        'https://accounts.youtube.com',
        'https://ogs.google.com',
        'https://mail.google.com',
        'https://accounts.google.com',
        'https://contacts.google.com',
        'https://ogs.google.com',
        'chrome://settings/',
        'https://myaccount.google.com',
        'https://github.com',
        'https://microsoft.com',
        'chrome://extensions/',
        'extensions',
        'https://www.douyin.com',

    ]

    #to record what url and how many scan in passive_scan
    passive_scan_url_count = 0  # Counter to track the number of processed URLs
    passive_scan_url = []  # List to store processed URLs

    active_scan_url_count = 0  
    active_scan_url = [] 


    # Process each URL individually (e.g., store them in a database)
    for url in urls:
        
        # Skip chrome://new-tab-page/ OR about:blank OR https://www.google.com/search?q=
        #if url.startswith('chrome://new-tab-page/'):
        #if url.startswith('chrome://new-tab-page/') or url.startswith('about:blank') or 'https://www.google.com/search?q=' in url:
        if any(url.startswith(pattern) or pattern in url for pattern in skip_patterns):
            #print(f"Skipping new tab page URL: {url}")

            continue

        else:
              
            try:
                #process_urls(url)
                ##print(url)
                # Process the URL using the function from process_urls.py
                #spider_results = process_urls(url)

                # Send results to PHP script
                #send_results_to_php(spider_results)
                

                ###spider scan
                scanID, spider_results = spider_scan(url)

                #get the domain name
                parsed_url = urlparse(url) # Parse the URL
                domain_name = parsed_url.netloc  # Extract the domain name
                print(f"Domain name: {domain_name}")

                send_spider_results_to_php(domain_name, scanID, spider_results)

                
                # Example usage
                result_hosts, result_alerts = passive_scan(url)
                print('Result Hosts:', result_hosts) #like domain name
                print('Result Alerts:') #this is alert info are be detect
                pprint(result_alerts)

                # Increment the counter for processed URLs
                passive_scan_url_count += 1
                # Append the processed URL to the list
                passive_scan_url.append(url)

                send_passive_scan_results_to_php(url,domain_name,scanID, result_hosts, result_alerts)


                active_scan_result_hosts, active_scan_result_alerts = active_scan(url)
                print('Result Hosts:', active_scan_result_hosts) #like domain name
                print('Result Alerts:') #this is alert info are be detect
                pprint(active_scan_result_alerts)

                # Increment the counter for processed URLs
                active_scan_url_count += 1
                # Append the processed URL to the list
                active_scan_url.append(url)

                send_active_scan_results_to_php(url,domain_name,scanID, active_scan_result_hosts, active_scan_result_alerts)
           
            except Exception as e:
                logger.error(f"Error connecting to ZAP: {e}")


            # Process the URLs using the function from process_urls.py
            ##process_urls(urls)
            #print(f"Processing URL: {url}")
                
        # Your processing logic here...
        # Print the total number of processed URLs
        print(f"Total Passive Scan URLs processed: {passive_scan_url_count}")
        # Print the processed URLs
        print("Processed Passive Scan URLs:", passive_scan_url)

              # Print the total number of processed URLs
        print(f"Total Active Scan URLs processed: {active_scan_url_count}")
        # Print the processed URLs
        print("Processed Active Scan URLs:", active_scan_url)


    # Send a response (optional)
    return jsonify({'status': 'success'})


def send_spider_results_to_php(domain_name,scan_id, spider_results):
    print("Sending data to PHP script:",domain_name, scan_id, spider_results)
    php_script_url = "http://localhost/FYP/save_spider_result.php"
    response = requests.post(php_script_url, json={"domain_name": domain_name, "scan_id": scan_id, "spider_results": spider_results}) 
    print("PHP script response:", response.text)

def send_passive_scan_results_to_php(url,domain_name,scan_id, result_hosts, result_alerts):
    print("Sending data to PHP script:", url, domain_name, scan_id, result_hosts, result_alerts)
    php_script_url = "http://localhost/FYP/save_passive_scan_result.php"
    response = requests.post(php_script_url, json={"link": url, "domain_name": domain_name, "scan_id": scan_id, "passive_results_hosts": result_hosts, "passive_result_alerts": result_alerts})
    print("PHP script response:", response.text)


def send_active_scan_results_to_php(url,domain_name,scan_id, active_scan_result_hosts, active_scan_result_alerts):
    print("Sending data to PHP script:", url, domain_name, scan_id, active_scan_result_hosts, active_scan_result_alerts)
    php_script_url = "http://localhost/FYP/save_active_scan_result.php"
    response = requests.post(php_script_url, json={"link": url, "domain_name": domain_name, "scan_id": scan_id, "active_scan_result_hosts": active_scan_result_hosts, "active_scan_result_alerts": active_scan_result_alerts})
    print("PHP script response:", response.text)


if __name__ == '__main__':
    app.run(port=8000)
