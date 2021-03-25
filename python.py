from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from time import sleep
import sys

try:
    targetEmail = sys.argv[1]
    userLink = sys.argv[2]
    chropmeOptions = webdriver.ChromeOptions()
    chropmeOptions.add_argument("user-data-dir=C:\\Users\\qq\\AppData\\Local\\Google\\Chrome\\User Data\\")
    chropmeOptions.add_argument('--profile-directory=Profile 1')
    browser = webdriver.Chrome(chrome_options=chropmeOptions)
    browser.get("https://mail.google.com/")
    sleep(10)
    try:
        browser.find_element_by_xpath("//*[@id=':5c']/div/div").click()
    except:
        browser.find_element_by_xpath("//*[@id=':54']/div/div").click()
    sleep(2)
    browser.find_element_by_xpath("//*[@id=':b8']").send_keys(targetEmail)
    browser.find_element_by_xpath("//*[@id=':aq']").send_keys("Aktivasyon İşlemi")
    browser.find_element_by_xpath("//*[@id=':bv']").send_keys("Aktivasyon işlemi için lütfen ")
    browser.find_element_by_xpath("//*[@id=':ca']").click()
    sleep(2)
    browser.find_element_by_xpath("//*[@id='linkdialog-text']").send_keys("buraya")
    browser.find_element_by_xpath("//*[@id='linkdialog-onweb-tab-input']").send_keys(userLink)
    sleep(5)
    try:
        browser.find_element_by_xpath("/html/body/div[38]/div[3]/button[1]").click()
    except:
        browser.find_element_by_xpath("/html/body/div[37]/div[3]/button[1]").click()
    sleep(2)
    browser.find_element_by_xpath("//*[@id=':bv']").send_keys(" tıklayınız")
    browser.find_element_by_xpath("//*[@id=':ag']").click()
    print("true")
    sleep(2)
except:
    print("false")

browser.close()
browser = None
sys.exit()