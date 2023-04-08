import requests
import random
from bs4 import BeautifulSoup

def gimmeSomeFood(location):
    URL = "https://www.facebook.com/marketplace/" + location.lower() + "/search?minPrice=0&maxPrice=0&sortBy=price_ascend&query=food&exact=false"
    page = requests.get(URL)
    soup = BeautifulSoup(page.content, "html.parser")
    specialClassID = "x3ct3a4"
    specialClassForLink = "x1i10hfl xjbqb8w x6umtig x1b1mbwd xaqea5y xav7gou x9f619 x1ypdohk xt0psk2 xe8uvvx xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x16tdsg8 x1hl2dhg xggy1nq x1a2a7pz x1heor9g x1lku1pv"
    indexNumber = random.randint(1,50)
    mydivs = soup.find_all("a", {"class": specialClassID})
    print(soup)
    print(len(mydivs))



    print(URL)
    #needs to choose a random item
    #needs to pluck that item's link
    #needs to pluck that item's image
    #needs to pluck that item's title
    #needs to pluck that item's description

#x9f619 x78zum5 x1r8uery xdt5ytf x1iyjqo2 xs83m0k x1e558r4 x150jy0e xnpuxes x291uyu x1uepa24 x1iorvi4 xjkvuk6

gimmeSomeFood("Portland")
