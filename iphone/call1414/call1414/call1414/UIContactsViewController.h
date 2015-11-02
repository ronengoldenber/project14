//
//  UIContactsViewController.h
//  call1414
//
//  Created by Yiftach Golan on 10/31/15.
//  Copyright © 2015 1414. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <AddressBook/AddressBook.h>
#import <AddressBookUI/AddressBookUI.h>
@import Contacts;
@import ContactsUI;
#import "Manager1414.h"
@interface UIContactsViewController : UITableViewController <CNContactPickerDelegate>
@property (nonatomic, strong) NSMutableArray *arrContactsData;
@property bool isPicker;
@end
