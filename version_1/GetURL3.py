from flask import Flask, request, jsonify
from spider_scanning1 import process_urls #get the function from scannning.py file
import logging

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
                process_urls(url)
            except Exception as e:
                logger.error(f"Error connecting to ZAP: {e}")


            # Process the URLs using the function from process_urls.py
            ##process_urls(urls)
            #print(f"Processing URL: {url}")
        # Your processing logic here...

    # Send a response (optional)
    return jsonify({'status': 'success'})

if __name__ == '__main__':
    app.run(port=8000)
