//
//  UIContactsViewController.m
//  call1414
//
//  Created by Yiftach Golan on 10/31/15.
//  Copyright © 2015 1414. All rights reserved.
//
#import "UIContactsViewController.h"

@implementation UIContactsViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
    // Do any additional setup after loading the view, typically from a nib.
    [self.tableView registerClass:[UITableViewCell class] forCellReuseIdentifier:@"Cell"];
    // Initialize the array if it's not yet initialized.
    if (_arrContactsData == nil) {
        _arrContactsData = [[NSMutableArray alloc] init];
    }
//    [self getAllContacts];
    [self showPicker];
    _isPicker = false;

}

-(void) showPicker
{
    CNContactPickerViewController *peoplePickerController = [[CNContactPickerViewController alloc] init];
    peoplePickerController.delegate = self;
    if ([self respondsToSelector:@selector(presentViewController:animated:completion:)]){
        [self presentViewController:peoplePickerController animated:YES completion:nil];
    }
}
-(void)viewDidAppear:(BOOL)animated
{
    if(_isPicker) {
        [self showPicker];
    }
    _isPicker = true;
}
- (void)contactPickerDidCancel:(CNContactPickerViewController *)picker
{
    NSLog(@"picker");
    _isPicker = false;
}
- (void)contactPicker:(CNContactPickerViewController *)picker didSelectContact:(CNContact *)contact
{
    NSLog(@"didSelectContact %@", contact.givenName);
    CNLabeledValue<CNPhoneNumber*> *phoneNumberLabel = [contact.phoneNumbers objectAtIndex:0];
    CNPhoneNumber *phoneNumber= [phoneNumberLabel value];
    NSString *phoneNumberStr = [phoneNumber stringValue];
    NSLog(@"Calling %@", phoneNumberStr);
    Manager1414 *manager1414 = [Manager1414 sharedManager];
    [manager1414 updateServer:phoneNumberStr];
    [manager1414 callTo1414];
    _isPicker = false;
}
- (void)contactPicker:(CNContactPickerViewController *)picker didSelectContactProperty:(CNContactProperty *)contactProperty
{
    NSLog(@"didSelectContactProperty");
    _isPicker = false;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

#pragma mark - Private method implementation



#pragma mark - Table View

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 1;
}

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
}

@end
