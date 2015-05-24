/* WizardViewController.h
 *
 * Copyright (C) 2012  Belledonne Comunications, Grenoble, France
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Library General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 */

#import <UIKit/UIKit.h>
#import <XMLRPCConnectionDelegate.h>
#import "UICompositeViewController.h"
#import "UILinphoneTextField.h"
#import "LinphoneUI/UILinphoneButton.h"


@interface WizardViewController : TPMultiLayoutViewController
<UITextFieldDelegate,
    UICompositeViewDelegate,
    XMLRPCConnectionDelegate,
    UIGestureRecognizerDelegate,
    UIAlertViewDelegate>
{
    @private
    UITextField *activeTextField;
    UIView *currentView;
    UIView *nextView;
    NSMutableArray *historyViews;
}

@property (nonatomic, retain) IBOutlet UIScrollView *contentView;
@property (retain, nonatomic) IBOutlet UIImageView *logoImage;

@property (nonatomic, retain) IBOutlet UIView *welcomeView;
@property (nonatomic, retain) IBOutlet UIView *choiceView;
@property (nonatomic, retain) IBOutlet UIView *createAccountView;
@property (nonatomic, retain) IBOutlet UIView *connectAccountView;
@property (nonatomic, retain) IBOutlet UIView *externalAccountView;
@property (nonatomic, retain) IBOutlet UIView *validateAccountView;
@property (retain, nonatomic) IBOutlet UIView *provisionedAccountView;

@property (nonatomic, retain) IBOutlet UIView *waitView;

@property (nonatomic, retain) IBOutlet UIButton *backButton;
@property (nonatomic, retain) IBOutlet UIButton *startButton;
@property (nonatomic, retain) IBOutlet UIButton *createAccountButton;
@property (nonatomic, retain) IBOutlet UIButton *connectAccountButton;
@property (nonatomic, retain) IBOutlet UIButton *externalAccountButton;
@property (retain, nonatomic) IBOutlet UIButton *remoteProvisioningButton;
@property (retain, nonatomic) IBOutlet UILinphoneButton *registerButton;
@property (retain, nonatomic) IBOutlet UILinphoneButton *purchaseButton;

@property (retain, nonatomic) IBOutlet UILinphoneTextField *createAccountUsername;
@property (retain, nonatomic) IBOutlet UILinphoneTextField *connectAccountUsername;
@property (retain, nonatomic) IBOutlet UILinphoneTextField *externalAccountUsername;

@property (retain, nonatomic) IBOutlet UITextField *provisionedUsername;
@property (retain, nonatomic) IBOutlet UITextField *provisionedPassword;
@property (retain, nonatomic) IBOutlet UILabel *statusLabel;
@property (retain, nonatomic) IBOutlet UIButton *UIFacebookButton;
@property (retain, nonatomic) IBOutlet UITextField *provisionedDomain;

@property (nonatomic, retain) IBOutlet UIImageView *choiceViewLogoImageView;
@property (retain, nonatomic) IBOutlet UISegmentedControl *transportChooser;

@property (nonatomic, retain) IBOutlet UITapGestureRecognizer *viewTapGestureRecognizer;

- (void)reset;
- (void)fillDefaultValues;

- (IBAction)onStartClick:(id)sender;
- (IBAction)onBackClick:(id)sender;
- (IBAction)onCancelClick:(id)sender;
//1414
- (IBAction)UIFacebookClick:(id)sender;
//1414
- (IBAction)onCreateAccountClick:(id)sender;
- (IBAction)onConnectLinphoneAccountClick:(id)sender;
- (IBAction)onExternalAccountClick:(id)sender;
- (IBAction)onCheckValidationClick:(id)sender;
- (IBAction)onRemoteProvisioningClick:(id)sender;
- (IBAction)onPurchaseAccountClick:(id)sender;

- (IBAction)onSignInClick:(id)sender;
- (IBAction)onSignInExternalClick:(id)sender;
- (IBAction)onRegisterClick:(id)sender;
- (IBAction)onProvisionedLoginClick:(id)sender;

@end