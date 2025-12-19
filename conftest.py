# conftest.py (FINAL VERSION FOR TASK 3)

import pytest
import pytest_html
import os
import base64

# --- REPORT HOOKS ---

# 1. Hook for embedding screenshots into the report
@pytest.hookimpl(tryfirst=True, hookwrapper=True)
def pytest_runtest_makereport(item, call):
    
    outcome = yield
    rep = outcome.get_result()

    if rep.when != "call":
        return

    # Use item.funcargs to reliably access the 'tester' fixture value
    test_instance = item.funcargs.get('tester') 
            
    if not test_instance or not hasattr(test_instance, "_last_screenshot"):
        return

    # Determine the status
    if rep.passed:
        status = "pass"
    elif rep.failed:
        if "Timeout" in str(rep.longrepr):
            status = "error_timeout"
        else:
            status = "error_crash"
    else:
        return

    # Retrieve the saved path
    screenshot_path = getattr(test_instance, "_last_screenshot", {}).get(status)
    
    if not screenshot_path or not os.path.exists(screenshot_path):
        return

    # Embed the image into the report using Base64 Data URI
    try:
        # Read the file in binary mode
        with open(screenshot_path, "rb") as image_file:
            # Encode the image data to Base64
            encoded_string = base64.b64encode(image_file.read()).decode('utf-8')
        
        # Create the Data URI
        mime_type = "image/png"
        data_uri = f"data:{mime_type};base64,{encoded_string}"

        # Attach the image data URI to the report extras
        rep.extras = getattr(rep, "extras", [])
        rep.extras.append(pytest_html.extras.image(
            data_uri, 
            name=f"Screenshot ({status.replace('_', ' ').title()})"
        ))
    except Exception:
        # Fail silently if embedding fails
        pass

# 2. NEW HOOK FOR TASK 3: Customize Report Title
def pytest_html_report_title(report):
    report.title = "Dessert Shop Reliability Test Report"
