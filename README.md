# vtiger
Extend functions to CRM Vtiger 6

> Without losing the integrity of the core

## Features

 - Workflow custom functions:
  - Update last modified time on related entity, when a comment is added. This is usefull to define workflow task with condition on modified time. For example, send a email if a opportunity was not updated (Add a comment is considered an update)

## Install

1. Upload and extract the last release file of this repo in your ROOT_PATH Vtiger folder.
2. Go to `http://<VTIGER_URL>/registerWorkflowCustomFunction.php` to register workflow custom functions

## Usage

### Workflow custom functions: 

#### Update last modified date when a comment is added

1. Create a new comment workflow. With empty conditions.
2. In Task section add a "Invoke Custom Function" action
3. Register a title and select "Update last modified date when a comment is added"


