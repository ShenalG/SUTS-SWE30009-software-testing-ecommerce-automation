# *Selenium CI Testing with GitHub Actions*  
This project implements a fully automated Continuous Integration (CI) pipeline that executes Selenium-based UI tests through GitHub Actions. The pipeline supports cross-platform testing on both Ubuntu and Windows environments and includes automated generation of detailed test reports.  
<br>

## Workflow Status Badges

| Pipeline | Status |
| :--- | :--- |
| *Ubuntu CI*<br>test-ubuntu.yml | [![Selenium Reliability Test on Ubuntu](https://github.com/SUTS-SWE30009/software-testing-project-extension-tasks-ShenalG/actions/workflows/test-ubuntu.yml/badge.svg)](https://github.com/SUTS-SWE30009/software-testing-project-extension-tasks-ShenalG/actions/workflows/test-ubuntu.yml) <br> <img width="600" height="500" alt="image" src="https://github.com/user-attachments/assets/eaf83b72-d772-4151-80dd-424b17c28571" />|
| *Windows CI*<br>test-windows.yml | [![Selenium Reliability Test on Windows](https://github.com/SUTS-SWE30009/software-testing-project-extension-tasks-ShenalG/actions/workflows/test-windows.yml/badge.svg)](https://github.com/SUTS-SWE30009/software-testing-project-extension-tasks-ShenalG/actions/workflows/test-windows.yml) <br> <img width="600" height="500" alt="image" src="https://github.com/user-attachments/assets/c82b1309-8cfc-4c9a-9e0e-2f97d8ae2472" />|
<br>

## CI Pipeline Definitions
 
### Task 1 - Ubuntu CI Pipeline

| Attribute | Details |
| :--- | :--- |
| *Workflow File* | .github/workflows/test-ubuntu.yml |
| *Trigger* | Manual (workflow_dispatch) |
| *Runner* | ubuntu-latest |
| *Timeout* | 30 minutes |

#### Ubuntu Pipeline Steps

1.  *Checkout repository:* Retrieves and clones the project source code.
2.  *Set up Python:* Configures the required Python 3.10 runtime environment.
3.  *Install dependencies:* Installs all necessary packages from requirements.txt (Ex. Selenium, Pytest, Pytest-HTML, etc.).
4.  *Install browser and WebDriver:* Installs Google Chrome, with Selenium Manager handling the WebDriver setup automatically.
5.  *Start the local web server:* Launches the application under test (A.U.T) using the provided startup script.
6.  *Run Selenium test script:* Executes the automated test suite using the CSV test case data.
<br>

### Task 2 - Windows CI Pipeline

| Attribute | Details |
| :--- | :--- |
| *Workflow File* | .github/workflows/test-windows.yml |
| *Trigger* | Manual (workflow_dispatch) |
| *Runner* | windows-latest |
| *Timeout* | 30 minutes |

#### Windows Pipeline Adjustments

The steps are functionally similar to Ubuntu, but adjusted for the Windows environment:

* *Python Setup* and *Dependency Installation* are performed using standard Windows/PowerShell commands.
* *ChromeDriver Path Configuration* is handled automatically by modern Selenium tooling or package managers such as Chocolatey, eliminating the need for manual driver management.
* *Test Execution* is carried out using the standard pytest command.
<br>

### Task 3 - Automated Test Report

The goal of Task 3 is to extend the CI pipelines (using test-ubuntu-report.yml and test-windows-report.yml) to automatically generate high-quality Selenium test reports.

### Workflow Status Badges

| Pipeline | Status |
| :--- | :--- |
| *Ubuntu CI - Report*<br>test-ubuntu-report.yml | [![Selenium Reliability Test on Ubuntu - Report](https://github.com/SUTS-SWE30009/software-testing-project-extension-tasks-ShenalG/actions/workflows/test-ubuntu(Report).yml/badge.svg)](https://github.com/SUTS-SWE30009/software-testing-project-extension-tasks-ShenalG/actions/workflows/test-ubuntu(Report).yml) <br> <img width="600" height="500" alt="image" src="https://github.com/user-attachments/assets/b6ae9d8b-459a-4e50-957d-8fad476cd246" />|
| *Windows CI - Report*<br>test-windows-report.yml | [![Selenium Reliability Test on Windows - Report](https://github.com/SUTS-SWE30009/software-testing-project-extension-tasks-ShenalG/actions/workflows/test-windows(Report).yml/badge.svg)](https://github.com/SUTS-SWE30009/software-testing-project-extension-tasks-ShenalG/actions/workflows/test-windows(Report).yml) <br> <img width="600" height="500" alt="image" src="https://github.com/user-attachments/assets/aa022f6f-50b6-4c80-b581-503c877a43df" />|

### How It Works

Tests are executed using the popular **pytest** framework combined with the **pytest-html** plugin.

* *Generates:*
    * *HTML report* (report/report.html)
    * *PDF version* (report/test-report.pdf)
* *Archiving:* Both reports are uploaded as *GitHub Artifacts* for easy download and review after the workflow completes.

### Report Contents

The generated report artifact is comprehensive, covering all necessary details for quality assurance:

| Detail | Description |
| :--- | :--- |
| *Total Tests Executed* | The overall count of test cases run. |
| *Passed / Failed Summary* | Clear counts with *color-coded statuses*: Passed (green), Failed (red), Skipped (yellow) |
| *Detailed Failure Info* | For each failed test, includes the *Test Name, **Error Message, **full traceback, and **Expected vs. Actual results*. |
| *Execution Time* | Duration recorded per test and the total runtime, crucial for cross-OS comparison. |
| *Visual Elements* | Improved readability via *status badges, **structured tables, and **collapsible sections*. |
| *PDF Version* | A static, highly portable file format for sharing, documentation, or submission. |


<br>  
<br>

## Running Tests Locally

To set up and run the tests on your local machine:

1.  *Install Dependencies:*
    bash
    pip install -r requirements.txt
    
2.  *Execute Tests and Generate Report:*
    bash
    pytest tests/test_dessertshop.py --html=report/report.html --self-contained-html
