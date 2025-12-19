import csv
import time
import os
from datetime import datetime
import pytest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service 
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException
import base64

# --- NEW IMPORT FOR CLOUD/CI ---
from webdriver_manager.chrome import ChromeDriverManager

# --- CONFIGURATION ---
# Logic: If running on GitHub Actions, use port 8000. Else use your XAMPP URL.
if os.getenv('GITHUB_ACTIONS') == 'true':
    BASE_URL = "http://localhost:8000/menu.php"
else:
    # Your local XAMPP URL (Keep this as your original path)
    BASE_URL = "http://localhost/swe30009/Assignment%203/menu.php" 

class DessertShopTest:
    def __init__(self):
        self.scr_dir = 'screenshots'
        if os.path.exists(self.scr_dir):
            import shutil
            shutil.rmtree(self.scr_dir)
        os.makedirs(self.scr_dir, exist_ok=True)
        
        # Dictionary to store the last screenshot path based on status
        self._last_screenshot = {} 

        options = Options()
        
        options.add_argument('--start-maximized')
        options.add_argument('--no-sandbox')
        options.add_argument('--disable-dev-shm-usage')

        # ⭐ DUAL MODE BROWSER SETUP
        if os.getenv('GITHUB_ACTIONS') == 'true':
            # --- CLOUD SETTINGS (UBUNTU) ---
            print("--- Running on GitHub Actions (Headless) ---")
            options.add_argument('--headless') 
            # Automatically installs the correct Linux Chromedriver
            service = Service(ChromeDriverManager().install())
        else:
            # --- LOCAL SETTINGS (WINDOWS) ---
            print("--- Running on Local Windows ---")
            # NOTE: Your hardcoded Windows path for local testing
            chromedriver_path = r"C:\Users\user\Downloads\chromedriver-win64\chromedriver-win64\chromedriver.exe"
            service = Service(chromedriver_path)

        self.driver = webdriver.Chrome(service=service, options=options)

    # --- KEEP THE REST OF THE CODE AS IS ---
    def run_single_test(self, row):
        test_id = row['ID']
        expected = row['expected']
        discount = row['discount']
        qty_fields = ['qty1','qty2','qty3','qty4','qty5','qty6','qty7','qty8']

        print(f"\n*** Running Test Case {test_id} ***")

        try:
            # 1. Force Navigate and Wait for Menu
            self.driver.get(BASE_URL)
            WebDriverWait(self.driver, 20).until(
                EC.visibility_of_element_located((By.CLASS_NAME, 'menu-container'))
            )

            # 2. Enter Quantities
            for q in qty_fields:
                input_element = self.driver.find_element(By.NAME, q)
                input_element.clear()
                
                val = row[q]
                if val != '0' and val != '':
                    input_element.send_keys(val)
                    time.sleep(0.1)

            # 3. Handle Discount Toggle Switch
            is_checked = self.driver.execute_script(
                "return document.getElementById('visualDiscountToggle').checked;"
            )
            should_be_on = (discount.upper() == "ON")

            if is_checked != should_be_on:
                slider = self.driver.find_element(By.CLASS_NAME, "slider")
                self.driver.execute_script("arguments[0].click();", slider)
            
            time.sleep(0.5)

            # 4. Click Submit Button
            submit_button = self.driver.find_element(By.CSS_SELECTOR, ".right-panel .order-btn")
            self.driver.execute_script("arguments[0].click();", submit_button)
            
            # 5. Verify Result on Cart Page
            WebDriverWait(self.driver, 20).until(
                EC.visibility_of_element_located((By.CLASS_NAME, 'receipt-container'))
            )
            
            total_elem = self.driver.find_element(By.XPATH, "//div[@class='final-total']/span[2]")
            actual_total_text = total_elem.text.strip()
            actual_total = actual_total_text.replace('RM','').strip()

            print(f"Actual Total: {actual_total}")

            # Assert
            diff = abs(float(actual_total) - float(expected))
            is_pass = diff < 0.01
            
            # Take screenshot before the assert statement runs
            if is_pass:
                self.take_screenshot_and_save_path("pass")
            else:
                self.take_screenshot_and_save_path("error_crash") 

            assert is_pass, f"Expected {expected}, got {actual_total}"


        except TimeoutException:
            self.take_screenshot_and_save_path("error_timeout")
            pytest.fail(f"Timeout during {test_id}")

        except Exception as e:
            self.take_screenshot_and_save_path("error_crash")
            pytest.fail(f"Crash during {test_id}: {str(e)}")

    def take_screenshot_and_save_path(self, status):
        # We don't print path messages here to keep stdout clean
        test_id = "LAST_RUN" 
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S_%f")
        filename = f"{test_id}_{timestamp}_{status}.png"
        path = os.path.join(self.scr_dir, filename)
        
        # Save the file
        self.driver.save_screenshot(path)
        
        # Update the dictionary the conftest.py hook reads
        self._last_screenshot[status] = path


    def quit(self):
        self.driver.quit()

# --- Pytest Integration ---
def load_test_cases(csv_path='test_cases_testing.csv'):
    with open(csv_path, newline='') as csvfile:
        return list(csv.DictReader(csvfile))

@pytest.fixture(scope="module")
def tester():
    t = DessertShopTest()
    yield t
    t.quit()

@pytest.mark.parametrize("test_case", load_test_cases())
def test_dessertshop(test_case, tester):
    tester.run_single_test(test_case)
