from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.common.by import By

chrome_options = Options()
chrome_options.add_argument("--headless") 

service = Service(ChromeDriverManager().install())
driver = webdriver.Chrome(service=service, options=chrome_options)

driver.get('https://ootimista.com.br/edicao-do-dia/o-otimista-edicao-impressa-de-14-08-2024?page=1')

driver.implicitly_wait(10)  

images = driver.find_elements(By.TAG_NAME, 'img')
image_urls = [img.get_attribute('src') for img in images if img.get_attribute('src').startswith('https://')]

for url in image_urls:
    print(url)

driver.quit()
