import requests
 
def make_api_request(url):
    try:
        response = requests.get(url)
        response.raise_for_status()  
# Raise an HTTPError if the response status code indicates an error
        return response.json()  
# Assuming the API returns JSON data
    except requests.ConnectionError:
        print(
"Network error: Could not connect to the API."
)
    except requests.Timeout:
        print(
"Request timed out. Try again later."
)
    except requests.TooManyRedirects:
        print(
"Too many redirects. Check your URL."
)
    except requests.HTTPError as e:
        print(f"HTTP error: {e}")
    except ValueError:
        print(
"Invalid JSON response from the API."
)
    except Exception as e:
        print(f"An unexpected error occurred: {e}")

# Example usage:
api_url = "http://127.0.0.1:8000/"
data = make_api_request(api_url)
if data:
    print("Received data from the API:", 
data
)