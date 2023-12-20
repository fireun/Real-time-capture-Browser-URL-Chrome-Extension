from flask import Flask, request, jsonify
from spider_scanning1 import process_urls #get the function from scannning.py file
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

    ]

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
                
                scanID, spider_results = process_urls(url)


                # Parse the URL
                parsed_url = urlparse(url)
                # Extract the domain name
                domain_name = parsed_url.netloc
                print(f"Domain name: {domain_name}")

                send_results_to_php(domain_name, scanID, spider_results)



            except Exception as e:
                logger.error(f"Error connecting to ZAP: {e}")


            # Process the URLs using the function from process_urls.py
            ##process_urls(urls)
            #print(f"Processing URL: {url}")
        # Your processing logic here...

    # Send a response (optional)
    return jsonify({'status': 'success'})


def send_results_to_php(domain_name,scan_id, spider_results):
    print("Sending data to PHP script:",domain_name, scan_id, spider_results)
    php_script_url = "http://localhost/FYP/save_result.php"
    response = requests.post(php_script_url, json={"domain_name": domain_name, "scan_id": scan_id, "spider_results": spider_results}) 
    print("PHP script response:", response.text)




if __name__ == '__main__':
    app.run(port=8000)
