from flask import Flask, request, jsonify
from spider_scanning1 import process_urls #get the function from scannning.py file
import logging
import requests  # Import the requests library

app = Flask(__name__)


# Configure logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

@app.route('/GetURL3', methods=['POST'])
def handle_data():
    data = request.get_json()

    # Access the URLs
    urls = data.get('urls', [])

    # Process each URL individually (e.g., store them in a database)
    for url in urls:
        
        # Skip chrome://new-tab-page/ OR about:blank OR https://www.google.com/search?q=
        #if url.startswith('chrome://new-tab-page/'):
        if url.startswith('chrome://new-tab-page/') or url.startswith('about:blank') or 'https://www.google.com/search?q=' in url:
            #print(f"Skipping new tab page URL: {url}")
            continue

        else:
              
            try:
                #process_urls(url)

                # Process the URL using the function from process_urls.py
                #spider_results = process_urls(url)

                # Send results to PHP script
                #send_results_to_php(spider_results)
                scanID, spider_results = process_urls(url)
                send_results_to_php(scanID, spider_results)



            except Exception as e:
                logger.error(f"Error connecting to ZAP: {e}")


            # Process the URLs using the function from process_urls.py
            ##process_urls(urls)
            #print(f"Processing URL: {url}")
        # Your processing logic here...

    # Send a response (optional)
    return jsonify({'status': 'success'})


def send_results_to_php(scan_id, spider_results):
    print("Sending data to PHP script:", scan_id, spider_results)
    php_script_url = "http://localhost/FYP/Web-OWASP/save_result.php"
    response = requests.post(php_script_url, json={"scan_id": scan_id, "spider_results": spider_results})
    print("PHP script response:", response.text)




if __name__ == '__main__':
    app.run(port=8000)
