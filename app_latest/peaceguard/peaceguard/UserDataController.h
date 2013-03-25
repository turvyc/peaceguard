//
//  UserDataController.h
//
//  Contributor(s): Ashley Lesperance
//
//  Copyright (c) 2013 Number 13 Developer's Group
//


#import <Foundation/Foundation.h>

@class User;

@interface UserDataController : NSObject

//Declaration of variables/object
@property (nonatomic, copy) User *currentUser;

//Method declarations
- (void)logUsername: (NSString *) username andPassword: (NSString *) password;

@end
