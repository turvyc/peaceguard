//
//  UserDataController.h
//
//  Contributor(s): Ashley Lesperance
//
//  Copyright (c) 2013 Number 123 Developer's Group
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
