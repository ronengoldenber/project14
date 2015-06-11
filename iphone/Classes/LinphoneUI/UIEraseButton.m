/* UIEraseButton.m
 *
 * Copyright (C) 2011  Belledonne Comunications, Grenoble, France
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or   
 *  (at your option) any later version.                                 
 *                                                                      
 *  This program is distributed in the hope that it will be useful,     
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of      
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the       
 *  GNU General Public License for more details.                
 *                                                                      
 *  You should have received a copy of the GNU General Public License   
 *  along with this program; if not, write to the Free Software         
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 */              

#import "UIEraseButton.h"
//1414
#import "Manager1414.h"
//1414


@implementation UIEraseButton

@synthesize addressField;


#pragma mark - Lifecycle Functions

- (void)initUIEraseButton {
	[self addTarget:self action:@selector(touchDown:) forControlEvents:UIControlEventTouchDown];
}

- (id)init {
    self = [super init];
    if (self) {
		[self initUIEraseButton];
    }
    return self;
}

- (id)initWithFrame:(CGRect)frame {
    self = [super initWithFrame:frame];
    if (self) {
		[self initUIEraseButton];
    }
    return self;
}

- (id)initWithCoder:(NSCoder *)decoder {
    self = [super initWithCoder:decoder];
    if (self) {
		[self initUIEraseButton];
	}
    return self;
}	

- (void)dealloc {
    [super dealloc];
	[addressField release];
}


#pragma mark - Action Functions

-(void) touchDown:(id) sender {
  	if ([addressField.text length] > 0) {
//1414
        NSString* address = [[Manager1414 sharedManager] getAddress];
        address = [address substringToIndex:[address length] - 1];
        [[Manager1414 sharedManager] setAddress:address];
        NSMutableString* m_message = [[NSMutableString alloc] init];
        [[Manager1414 sharedManager] getNumberFormat:address number_format:m_message];
        [addressField setText:m_message];
        [m_message release];
//        [addressField setText:[addressField.text substringToIndex:[addressField.text length]-1]];
//1414

    }
}


#pragma mark - UILongTouchButtonDelegate Functions

- (void)onRepeatTouch {
}

- (void)onLongTouch {
    [addressField setText:@""];
}

@end
