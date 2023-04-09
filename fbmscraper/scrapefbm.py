import random
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.common.by import By

def gimmeSomeFood(location):
    URL = "https://www.facebook.com/marketplace/" + location.lower() + "/search?minPrice=0&maxPrice=0&sortBy=price_ascend&query=food&exact=false"
    options = Options()
    options.headless = True
    options.add_argument("--window-size=1920,1200")
    driver = webdriver.Chrome(options=options, service=Service(ChromeDriverManager().install()))
    driver.get(URL)

    specialClassForImage = "xt7dq6l xl1xv1r x6ikm8r x10wlt62 xh8yej3"
    specialClassForLink = "x1i10hfl xjbqb8w x6umtig x1b1mbwd xaqea5y xav7gou x9f619 x1ypdohk xt0psk2 xe8uvvx xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x16tdsg8 x1hl2dhg xggy1nq x1a2a7pz x1heor9g x1lku1pv"
    indexNumber = random.randint(1,17)

    link = WebDriverWait(driver, 20).until(expected_conditions.visibility_of_element_located((By.XPATH, '//a[@class="'+specialClassForLink+'"]')))
    image = WebDriverWait(driver, 20).until(expected_conditions.visibility_of_element_located((By.XPATH, '//img[@class="'+specialClassForImage+'"]')))

    link = driver.find_elements(by=By.XPATH, value='//a[@class="'+specialClassForLink+'"]')
    image = driver.find_elements(by=By.XPATH, value='//img[@class="'+specialClassForImage+'"]')
    image = image[indexNumber]
    link = link[indexNumber]


    imag = image.get_attribute('src')
    title = image.get_attribute('alt')
    link = link.get_attribute('href')

    driver.quit()

    return title, imag, link