//
//  UserDataController.h
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-02-15.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <Foundation/Foundation.h>

@class User;

@interface UserDataController : NSObject

//Declaration of variables/object
@property (nonatomic, copy) User *currentUser;

//Method declarations
- (BOOL)authenticateUser:(User *)theUser;
- (void)logUsername: (NSString *) username andPassword: (NSString *) password;

@end
